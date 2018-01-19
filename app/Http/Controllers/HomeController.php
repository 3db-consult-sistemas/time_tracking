<?php

namespace App\Http\Controllers;

use App\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now()->format('Y-m-d');

        $entries = TimeEntry::where('user_id', auth()->id())
            ->whereRaw('DATE(check_in) = ?', $now)
            ->select([
                'type',
                DB::raw("TIME(check_in) as check_in"),
                DB::raw("TIME(check_out) as check_out")
            ])
            ->orderBy('check_in', 'desc')
            ->get();

        return view('home.index', compact('entries'));
    }
}
