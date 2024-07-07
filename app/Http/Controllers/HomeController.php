<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Calendar;

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
        // Get the user
        $user = Auth::user();
    
        // Get the user's team names
        $teammapping = \App\TeamMapping::where('username', '=', $user->username)->pluck('team_name')->toArray();
    
        // Get the projects associated with the user's team names
        $pros = \App\Project::whereIn('team_name', $teammapping)->get();
    
        // Calculate progress for each project
        $now = Carbon::now();
foreach ($pros as $project) {
    $start = Carbon::parse($project->start_date);
    $end = Carbon::parse($project->end_date);
    $totalDuration = $start->diffInDays($end);
    $elapsedDuration = $start->diffInDays($now);

    // Calculate progress as a whole number percentage
    $project->progress = round(min(100, max(0, ($elapsedDuration / $totalDuration) * 100)));
}

        // Fetch events from the calendar database
        $events = Calendar::all();
    
        // Prepare an array of all months in the current year
        $allMonths = [];
        $startMonth = Carbon::now()->startOfYear(); // Start from January of the current year
        $endMonth = Carbon::now()->endOfYear();     // End at December of the current year
    
        // Loop through each month of the current year and format it as "M Y"
        while ($startMonth <= $endMonth) {
            $allMonths[] = $startMonth->format('M Y');
            $startMonth->addMonth(); // Move to the next month
        }
    
        // Group events by month-year and count occurrences
        $eventCounts = $events->groupBy(function ($event) {
            return Carbon::parse($event->start_date)->format('M Y');
        })->map(function ($group) {
            return $group->count();
        });
    
        // Initialize counts for all months with 0
        $countsPerMonth = array_fill_keys($allMonths, 0);
    
        // Merge actual counts with initialized array
        $countsPerMonth = array_merge($countsPerMonth, $eventCounts->toArray());
    
        // Get the bug tracking information and sort by status
        $bugTrackingData = \App\Bugtracking::select('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->get();
    
        // Prepare the data for the pie chart
        $bugChartData = [
            'labels' => $bugTrackingData->pluck('status')->toArray(),
            'series' => $bugTrackingData->pluck('count')->toArray()
        ];

        // dd($pros);
    
        return view('home')
            ->with('pros', $pros)
            ->with('countsPerMonth', $countsPerMonth)
            ->with('bugChartData', $bugChartData);
    }
    

}
