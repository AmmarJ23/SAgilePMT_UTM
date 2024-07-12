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
    foreach ($pros as $project) {
        $projectName = $project->proj_name;
        $start = Carbon::parse($project->start_date);
        $end = Carbon::parse($project->end_date);
        $now = Carbon::now();
        
        // Calculate total project duration
        $totalDuration = $start->diffInDays($end);
        
        // Calculate elapsed duration based on the current date or end date, whichever is earlier
        $elapsedDuration = $start->diffInDays(min($now, $end));
        
        // Calculate progress as a percentage
        $progressPercentage = round(min(100, max(0, ($elapsedDuration / $totalDuration) * 100)));
        
        // Fetch all sprints related to this project
        $sprints = \App\Sprint::where('proj_name', $projectName)->get();
        
        if ($sprints->isEmpty()) {
            // If there are no sprints, set progress to 0%
            $project->progress = 0;
        } else {
            // Count total sprints and completed sprints
            $totalSprints = $sprints->count();
            $completedSprints = $sprints->filter(function ($sprint) {
                return Carbon::parse($sprint->end_sprint)->isPast();
            })->count();
            
            // Calculate sprint-based progress as a percentage
            $sprintProgressPercentage = round(($completedSprints / $totalSprints) * 100);
            
            // Average progress from project timeline and sprint completion
            $project->progress = round(($progressPercentage + $sprintProgressPercentage) / 2);
        }
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
        $bugTrackingDataByStatus = \App\Bugtracking::select('status')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('status')
        ->get();

        // Get the bug tracking information and sort by severity
        $bugTrackingDataBySeverity = \App\Bugtracking::select('severity')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('severity')
            ->get();

        // Prepare the data for the pie chart by status
        $bugChartData = [
            'status' => [
                'labels' => $bugTrackingDataByStatus->pluck('status')->toArray(),
                'series' => $bugTrackingDataByStatus->pluck('count')->toArray()
            ],
            'severity' => [
                'labels' => $bugTrackingDataBySeverity->pluck('severity')->toArray(),
                'series' => $bugTrackingDataBySeverity->pluck('count')->toArray()
            ]
        ];

        // dd($pros);
    
        return view('home')
            ->with('pros', $pros)
            ->with('countsPerMonth', $countsPerMonth)
            ->with('bugChartData', $bugChartData);
    }
    

}
