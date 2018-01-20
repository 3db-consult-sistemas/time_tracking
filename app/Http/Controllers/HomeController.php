<?php

namespace App\Http\Controllers;

use App\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $now = Carbon::now()->startOfWeek()->format('Y-m-d');

        $entries = TimeEntry::where('user_id', auth()->id())
            ->whereRaw('DATE(check_in) >= ?', $now)
            ->select([
                DB::raw("DATE(check_in) as date"),
                DB::raw("SUM(TIMESTAMPDIFF(SECOND, check_in, IFNULL(check_out, now()))) as secs")
            ])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('home.index', compact('entries'));
    }
}
