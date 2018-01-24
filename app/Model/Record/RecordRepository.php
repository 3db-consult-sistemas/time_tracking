<?php

namespace App\Model\Record;

use Carbon\Carbon;
use App\Model\Record\Record;
use Illuminate\Support\Facades\DB;

class RecordRepository
{
	/**
	 * Instantiate a repository's model.
	 *
	 * @return Record
	 */
	public function getModel()
	{
		return new Record;
    }

    /**
     * Obtengo el estado actual del usuario.
     *
     * @param $userId
     * @return void
     */
    public function status($userId)
    {
        $record = $this->active($userId);

        if ($record == null) {
            return [ 'code' => 'close', 'activeId' => null ];
        }

        if ($record->check_out != null) {
            return [ 'code' => 'absence-planned', 'activeId' => $record->id ];
        }

        return [
            'code' => $record->type == 'ausencia' ? 'absence' : 'open',
            'activeId' => $record->id
        ];
    }

    /**
     * Obtengo los registros activos comprobando que el campo 'check_out' este a null o la
     * fecha actual se encuetre entre 'check_in' y 'check_out',
     *
     * @param $id
     * @return void
     */
    public function active($userId = null)
    {
        $query = $this->getModel()
            ->whereNull('check_out')
            ->orWhere(function ($query) {
                $now = Carbon::now();
                $query->where('check_out', '>', $now)->where('type', 'ausencia');
            });

        return $userId != null
			? $query->where('user_id', $userId)->first()
			: $query->get();
    }

    /**
     * Realizo el 'check in' para el usuario logeado.
     *
     * @param $data
     * @return boolean
     */
    public function create($data)
    {
        $data['check_in'] = Carbon::now();

        return $this->getModel()->create($data);
    }

    /**
     * Realizo el 'check out' para el usuario logeado.
     *
     * @param $id
     * @return boolean
     */
    public function close($id)
    {
 		return $this->getModel()
			->where('id', $id)
			->update(['check_out' => Carbon::now()]);
    }

    /**
     * Actualizo los registros de entrada cuando se abre, cierra o cancela una ausencia.
     *
     * @param $data
     * @return boolean
     */
    public function absence($data)
    {
        $now = Carbon::now();

        $data['check_in'] = is_numeric($data['duration']) && $data['check_in'] != null
            ? $data['check_in']
            : $now;

        $data['check_out'] = is_numeric($data['duration'])
            ? $data['check_in']->copy()->addMinutes($data['duration'])
            : null;

        $entry = $this->getModel()->where('id', $data['id'])->first();

        if ($entry->check_in > $data['check_in']) {
            return $entry->delete();
        }

        return DB::transaction(function () use ($now, $data) {
            DB::table('records')->where('id', $data['id'])->update([
                'check_out' => $now
            ]);

            unset($data['id']);
            unset($data['duration']);

            DB::table('records')->insert($data);
        });
    }

    /**
     * Fetch data.
     *
     * @param $action
     * @return array
     */
    public function fetch($data)
    {
        if ($data['aggregate'] == 'record') {
            return $this->allPaginate($data);
        }

        $method = "groupBy{$data['aggregate']}";

        return DB::select(DB::raw($this->$method($data)));
    }

    /**
     * Get the query to group by by month.
     *
     * @return string
     */
    protected function groupByMonth($data)
    {
        $query = $this->groupByDay($data);

        return "SELECT user_name, user_id, _month, SUM(secs) as secs, SUM(hoursToWork) as hoursToWork FROM ({$query}) as tmp
            GROUP BY user_id, _month
            ORDER BY user_name ASC, _month DESC";
    }

    /**
     * Get the query to group by by week.
     *
     * @return string
     */
    protected function groupByWeek($data)
    {
        $query = $this->groupByDay($data);

        return "SELECT user_name, user_id, _week, SUM(secs) as secs, SUM(hoursToWork) as hoursToWork FROM ({$query}) as tmp
            GROUP BY user_id, _week
            ORDER BY user_name ASC, _week DESC";
    }

    /**
     * Get the query to group by by day.
     *
     * @return string
     */
    protected function groupByDay($data)
    {
        $query = $this->all($data);

        return "SELECT user_name, user_id, _date, _week, _month, SUM(secs) as secs, hoursToWork FROM ({$query}) as tmp
                GROUP BY user_id, _date, _week, _month, hoursToWork
                ORDER BY user_name ASC, _date DESC";
    }

    /**
     * Get the query to get all entries.
     *
     * @return string
     */
    protected function all($data)
    {
        $query = "SELECT
                users.name as user_name,
                records.user_id,
                DATE(records.check_in) as _date,
                WEEK(records.check_in, 1)  as _week,
                MONTH(records.check_in)  as _month,
                records.type,
                records.check_in,
                records.check_out,
                TIMESTAMPDIFF(SECOND, records.check_in, IFNULL(records.check_out, now())) as secs,
                (SELECT CASE DATE_FORMAT(records.check_in, '%w')
                    WHEN 0 THEN tmp.sunday
                    WHEN 1 THEN tmp.monday
                    WHEN 2 THEN tmp.tuesday
                    WHEN 3 THEN tmp.wednesday
                    WHEN 4 THEN tmp.thursday
                    WHEN 5 THEN tmp.friday
                    WHEN 6 THEN tmp.saturday
                END AS '0') as hoursToWork
                FROM records
                LEFT JOIN hours_day as tmp ON tmp.id = (
                    SELECT id FROM hours_day
                    WHERE hours_day.user_id = records.user_id AND hours_day.from_date <= records.check_in
                    ORDER BY hours_day.from_date DESC
                    LIMIT 1)
                LEFT JOIN users ON users.id = records.user_id
                WHERE DATE(records.check_in) >= '{$data['from']}' AND DATE(records.check_in) <= '{$data['to']}'";

        if (is_numeric($data['user'])) {
            return $query .= " AND records.user_id IN ({$data['user']})";
        }

        if ($data['user'] != null) {
            return $query .= " AND users.name LIKE '%{$data['user']}%'";
        }

        return $query;
    }

    /**
     * Get all the records.
     *
     * @return collection
     */
    protected function allPaginate($data)
    {
        $query = $this->getModel()
            ->join('users', 'users.id', '=', 'records.user_id')
            ->whereRaw("DATE(records.check_in) >= '{$data['from']}'")
            ->select([
                'users.name',
                'records.type',
                DB::raw("DATE(records.check_in) as date"),
                DB::raw("TIME(records.check_in) as time_in"),
                DB::raw("TIME(records.check_out) as time_out"),
                DB::raw("TIMESTAMPDIFF(SECOND, records.check_in, IFNULL(records.check_out, now())) as secs")
            ])
            ->orderBy('records.check_in', 'desc');

        if (is_numeric($data['user'])) {
            $query->where('records.user_id', $data['user']);
        }
        else if ($data['user'] != null) {
            $query->where('users.name', 'LIKE', "%{$data['user']}%");
        }

        return $query->paginate(15)->appends($data);
    }
}
