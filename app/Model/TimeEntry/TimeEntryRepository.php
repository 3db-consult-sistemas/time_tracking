<?php

namespace App\Model\TimeEntry;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Model\TimeEntry\TimeEntry;
use Illuminate\Database\Eloquent\Model;

class TimeEntryRepository
{
	/**
	 * Instantiate a repository's model.
	 *
	 * @return TimeEntry
	 */
	public function getModel()
	{
		return new TimeEntry;
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
            DB::table('time_entries')->where('id', $data['id'])->update([
                'check_out' => $now
            ]);

            unset($data['id']);
            unset($data['duration']);

            DB::table('time_entries')->insert($data);
        });
    }








    /**
     * Fetch data.
     *
     * @param $action
     * @return array
     */
    public function fetch($action)
    {
        $query = $this->$action();

        return DB::select(DB::raw($query));
    }

    /**
     * Get the query to group by by month.
     *
     * @return string
     */
    protected function groupByMonth()
    {
        $query = $this->groupByDay();

        return "SELECT _month, SUM(secs) as secs, SUM(hoursToWork) as hoursToWork FROM ({$query}) as tmp
            GROUP BY _month
            ORDER BY _month DESC";
    }

    /**
     * Get the query to group by by day.
     *
     * @return string
     */
    protected function groupByDay()
    {
        $query = $this->all();

        return "SELECT _date, _week, _month, SUM(secs) as secs, hoursToWork FROM ({$query}) as tmp
                GROUP BY _date, _week, _month, hoursToWork
                ORDER BY _date DESC";
    }

    /**
     * Get the query to get all entries.
     *
     * @return string
     */
    protected function all()
    {
        $from = Carbon::now()->startOfWeek()->format('Y-m-d');
        $to = Carbon::now()->format('Y-m-d');

        return "SELECT
                DATE(te.check_in) as _date,
                WEEK(te.check_in, 1)  as _week,
                MONTH(te.check_in)  as _month,
                te.type,
                te.check_in,
                te.check_out,
                TIMESTAMPDIFF(SECOND, te.check_in, IFNULL(te.check_out, now())) as secs,
                (SELECT CASE DATE_FORMAT(te.check_in, '%w')
                    WHEN 0 THEN tmp.sunday
                    WHEN 1 THEN tmp.monday
                    WHEN 2 THEN tmp.tuesday
                    WHEN 3 THEN tmp.wednesday
                    WHEN 4 THEN tmp.thursday
                    WHEN 5 THEN tmp.friday
                    WHEN 6 THEN tmp.saturday
                END AS '0') as hoursToWork
                FROM time_entries te
                LEFT JOIN hours_day as tmp ON tmp.id = (
                    SELECT id FROM hours_day
                    WHERE hours_day.user_id = 1 AND hours_day.from_date <= te.check_in
                    ORDER BY hours_day.from_date DESC
                    LIMIT 1)
                WHERE te.user_id = 1 AND DATE(te.check_in) >= '{$from}' AND DATE(te.check_in) <= '{$to}'
                ORDER BY _date DESC";
    }
}
