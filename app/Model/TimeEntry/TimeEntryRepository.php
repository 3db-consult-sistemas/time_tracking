<?php

namespace App\Model\TimeEntry;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TimeEntryRepository
{
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
