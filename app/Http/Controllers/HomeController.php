<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Record\RecordRepository;

class HomeController extends Controller
{
    protected $recordRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RecordRepository $recordRepository)
    {
        $this->recordRepository = $recordRepository;

        $this->middleware(['auth', 'ismobile']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->id();

		$entries = $this->recordRepository->fetch([
            'aggregate' => 'day',
            'userId' => $userId,
            'from' => Carbon::now()->startOfWeek()->format('Y-m-d'),
            'to' => Carbon::now()->format('Y-m-d')
        ]);

        $status = $this->recordRepository->status($userId);

		$lastRecord = $this->recordRepository->lastRecord($userId);

		$projects = auth()->user()->availableProjects();

        return view('home.index', compact('entries', 'status', 'projects', 'lastRecord'));
    }
}
