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

        $status = [
            'code' => $active != null ? 'open' : 'close',
            'activeId' => $active != null ? $active->id : null
        ];

        return view('home.index', compact('entries', 'status'));
    }
}
