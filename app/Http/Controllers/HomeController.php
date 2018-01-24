<?php

namespace App\Http\Controllers;

use App\Model\Record\RecordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = $this->recordRepository->fetch('groupByDay');

        $status = $this->recordRepository->status(auth()->id());

        return view('home.index', compact('entries', 'status'));
    }
}
