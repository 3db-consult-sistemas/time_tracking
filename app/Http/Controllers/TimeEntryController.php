<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\TimeEntry\TimeEntry;
use Illuminate\Support\Facades\Auth;
use App\Model\TimeEntry\TimeEntryRepository;

class TimeEntryController extends Controller
{
    protected $timeEntryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TimeEntryRepository $timeEntryRepository)
    {
        $this->timeEntryRepository = $timeEntryRepository;

        $this->middleware('auth');
    }

    /**
     * Store a time entry resource (check in).
     *
     * @return redirect
     */
    public function checkIn()
    {
        $data = [
            'user_id' => auth()->id()
        ];

        if(! $this->timeEntryRepository->create($data)) {
            return redirect()
                ->route('home')
                ->withErrors('status', 'No se ha podido realizar el Check-In.');
		}

        return redirect()->route('home');
    }

    /**
     * Update a time entry resource (check out).
     *
     * @param  $entryId
     * @return redirect
     */
    public function checkOut($entryId)
    {
        if(! $this->timeEntryRepository->close($entryId)) {
            return redirect()
                ->route('home')
                ->withErrors('status', 'No se ha podido realizar el Check-Out.');
		}

        return redirect()->route('home');
    }

    /**
     * Close current entry and create a absence time entry.
     *
     * @param  $entryId
     * @return redirect
     */
    public function absence($entryId)
    {
        $data = [
            'entry' => $entryId,
            'user_id' => auth()->id(),
            'type' => 'ausencia'
        ];

        $this->timeEntryRepository->absence($data);

        return redirect()->route('home');
    }

    public function absenceFinish($entryId)
    {
        $data = [
            'entry' => $entryId,
            'user_id' => auth()->id(),
            'type' => 'ordinaria'
        ];

        $this->timeEntryRepository->absence($data);

        return redirect()->route('home');
    }

    public function absenceCancel($entryId)
    {
        $this->timeEntryRepository->absenceCancel($entryId);

        return redirect()->route('home');
    }








    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array_only($request->all(), ['name']);
        $data = array_filter($data, 'strlen');

        /*
        // $q = $this->getModel()->select();
        $q = TimeEntry::select();

        foreach ($data as $field => $value) {
            $filterMethod = 'filterBy' . studly_case($field);

            if(method_exists(get_called_class(), $filterMethod)) {
                $this->$filterMethod($q, $value);
            }
            else {
                $q->where($field, $data[$field]);
            }
        }
        $q->orderBy('end_date', 'desc');
        return $paginate
            ? $q->paginate(15)->appends($data)
            : $q->get();
            */

        $now = Carbon::now()->format('Y-m-d');

        $query = TimeEntry::join('users', 'users.id', '=', 'time_entries.user_id')
            //->where('user_id', auth()->id())
            //->whereRaw('DATE(check_in) = ?', $now)
            ->select([
                'users.name',
                'time_entries.type',
                DB::raw("DATE(time_entries.check_in) as date"),
                DB::raw("TIME(time_entries.check_in) as time_in"),
                DB::raw("TIME(time_entries.check_out) as time_out"),
                DB::raw("TIMESTAMPDIFF(SECOND, time_entries.check_in, IFNULL(time_entries.check_out, now())) as secs")
            ])
            ->orderBy('time_entries.check_in', 'desc');

        if (isset($data['name'])) {
            $query->where('name', 'LIKE', "%{$data['name']}%");
        }

        $entries = $query->paginate(15)->appends($data);

        return view('entries.index', compact('entries'));
    }
}
