<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\TimeEntry\TimeEntryRepository;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = $this->timeEntryRepository->fetch('groupByDay');

        $active = $this->timeEntryRepository->active(auth()->id());

        $status = [ 'code' => 'close', 'activeId' => null ];

        if ($active != null) {

            if ($active->check_out != null) {
                $code = 'absence-planned';
            }
            else {
                $code = $active->type == 'ausencia' ? 'absence' : 'open';
            }

            $status = [ 'code' => $code, 'activeId' => $active->id ];
        }

        return view('home.index', compact('entries', 'status'));
    }
}
