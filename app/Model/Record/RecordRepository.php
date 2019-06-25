<?php

namespace App\Model\Record;

use Carbon\Carbon;
use App\Model\Helpers;
use App\Model\Record\Record;
use App\Model\Record\NightShift;
use Illuminate\Support\Facades\DB;

class RecordRepository
{
    use Helpers;

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
     * Obtengo el ultimo check in realizado.
     *
     * @param $userId
     * @return void
     */
    public function lastCheckIn($userId)
    {
        return $this->getModel()
            ->where('user_id', $userId)
            ->whereNotNull('check_out')
            ->orderBy('check_out', 'desc')
            ->first();
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
            ->where(function ($q) {
                $q->whereNull('check_out')
                    ->orWhere(function ($q) {
                        $q->where('check_out', '>', Carbon::now())->where('type', 'ausencia');
                });
            });

        return $userId != null
            ? $query->where('user_id', $userId)->first()
            : $query->get();
    }

    /**
     * NO SE USA
     * Determino si un usuario se encuentra durante el tiempo de la comida.
     *
     * @param $id
     * @return void
     */
    public function inLunchTime($userId)
    {
        $entry = $this->getModel()
            ->select('check_out', 'comments')
            ->where('user_id', $userId)
            ->orderBy('check_out', 'desc')
            ->first();

        if ($entry['comments'] != 'comida') {
            return false;
        }

        if (Carbon::now()->diffInSeconds($entry['check_out']) <= config('options.lunch_time')) {
            return true;
        }

        return false;
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
        $data['ip'] = ip2long($this->getIp());

        return $this->getModel()->create($data);
    }

    /**
     * Realizo el 'check out' para el usuario logeado.
     *
     * @param $id
     * @return boolean
     */
    public function close($id, $comments = null)
    {
		$entry = $this->getModel()->where('id', $id)->first();

		if (is_null($entry)) { return false; }

		$now = Carbon::now();

		$entry->check_out = $now;
		$entry->comments = $comments;
		$entry->night_shift = NightShift::getTimeInSeconds($entry->check_in, $now);
		return $entry->save();
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

		$data['night_shift'] = NightShift::getTimeInSeconds($data['check_in'], $data['check_out'] ?? $now);

        $entry = $this->getModel()->where('id', $data['id'])->first();

        if ($entry->check_in > $data['check_in']) {
            return $entry->delete();
        }

        return DB::transaction(function () use ($entry, $data, $now) {
			// Cierro el registro actual
			$entry->check_out = $now;
			$entry->night_shift = NightShift::getTimeInSeconds($entry->check_in, $now);
			$entry->save();

			// Creo el registro de ausencia
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
		$method = $data['aggregate'] == 'record' ? "all" : "groupBy{$data['aggregate']}";

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

        return "SELECT user_name, user_id, _month, SUM(night_shift) as night_shift, SUM(secs) as secs, AVG(secs) as average, SUM(hoursToWork) as hoursToWork FROM ({$query}) as tmp
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

        return "SELECT user_name, user_id, _week, SUM(night_shift) as night_shift, SUM(secs) as secs, AVG(secs) as average, SUM(hoursToWork) as hoursToWork FROM ({$query}) as tmp
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
        $seconds = config('options.add_seconds_to_aggregate');

        return "SELECT user_name, user_id, _date, _month, _week, SUM(night_shift) as night_shift, SUM(secs)+{$seconds} as secs, hoursToWork FROM ({$query}) as tmp
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
                WEEK(records.check_in, 1) as _week,
                MONTH(records.check_in) as _month,
                records.type,
                records.comments,
                records.check_in,
                records.check_out,
                records.night_shift,
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
                LEFT JOIN timetables as tmp ON tmp.id = (
                    SELECT id FROM timetables
                    WHERE timetables.user_id = records.user_id AND timetables.from_date <= records.check_in
                    ORDER BY timetables.from_date DESC
                    LIMIT 1)
                LEFT JOIN users ON users.id = records.user_id
                WHERE DATE(records.check_in) >= '{$data['from']}' AND DATE(records.check_in) <= '{$data['to']}'";

        if (is_numeric($data['userId'])) {
            $query .= " AND records.user_id = '{$data['userId']}'";
        }

        return $query .= " ORDER BY user_name ASC, records.check_in DESC";
    }

    /**
     * Get all the records.
     *
     * @return collection
     */
    public function fetchPaginate($data)
    {
        return $this->getModel()
            ->join('users', 'users.id', '=', 'records.user_id')
            //->whereRaw("DATE(records.check_in) >= '{$data['from']}'")
            ->where('records.user_id', $data['userId'])
            ->select([
                'users.name',
                'records.type',
                DB::raw("DATE(records.check_in) as date"),
                DB::raw("TIME(records.check_in) as time_in"),
                DB::raw("TIME(records.check_out) as time_out"),
                DB::raw("TIMESTAMPDIFF(SECOND, records.check_in, IFNULL(records.check_out, now())) as secs"),
                'records.comments',
                DB::raw("INET_NTOA(records.ip) as ip")
            ])
            ->orderBy('records.check_in', 'desc')
            ->paginate(15)
            ->appends($data);
    }
}
