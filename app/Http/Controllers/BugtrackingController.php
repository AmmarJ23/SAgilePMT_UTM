<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bugtracking;
use App\User;
use App\Project;
use App\Mail\BugAssignedNotification;
use App\Mail\BugDueSoonNotification;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Bugscore;

class BugtrackingController extends Controller
{

    public function index(Request $request, $projectId)
{
    // Fetch all bugtrackings for the specified project from the database
    $bugtracks = Bugtracking::where('project_id', $projectId)
    ->orderBy('created_at', 'desc') // Sort by date created
    ->get();

    // Get unique statuses from bugtrackings
    $statuses = $bugtracks->unique('status')->pluck('status');

    // Return the view with bugtracks data, statuses, and projectId
    return view('bugtrack.index', compact('bugtracks', 'statuses', 'projectId'));
}



public function create($projectId = null)
{
    // Fetch all users from the database
    $users = User::all();

    // Get the authenticated user
    $authUser = auth()->user();

    // Return the view with users data, authenticated user, and projectId
    return view('bugtrack.create', compact('users', 'authUser', 'projectId'));
}



public function store(Request $request, $projectId)
{
    // Validate the request
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'severity' => 'string|max:255',
        'status' => 'string|max:255',
        'flow' => 'nullable|string',
        'expected_results' => 'nullable|string',
        'actual_results' => 'nullable|string',
        'assigned_to' => 'nullable|integer',
        'due_date' => 'nullable|date', // Add validation rule for due_date
    ]);

    // Set the reported_by field to the authenticated user's ID
    $validatedData['reported_by'] = auth()->user()->id;

    // Add projectId to the validated data
    $validatedData['project_id'] = $projectId;

    // Fetch project name based on projectId
    $project = Project::find($projectId);
    $projectName = $project ? $project->proj_name : 'Unknown Project'; // Adjust as per your Project model and field names

    // Create new Bugtrack instance
    $bugtrack = Bugtracking::create([
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'severity' => $validatedData['severity'],
        'status' => $validatedData['status'],
        'flow' => $validatedData['flow'],
        'expected_results' => $validatedData['expected_results'],
        'actual_results' => $validatedData['actual_results'],
        'assigned_to' => $validatedData['assigned_to'],
        'reported_by' => $validatedData['reported_by'],
        'project_id' => $validatedData['project_id'],
        'due_date' => $validatedData['due_date'], 
    ]);

    // Add project name to the $bugtrack object
    $bugtrack->projectName = $projectName;

    // Send email notification to the assigned user
    if ($bugtrack->assigned_to) {
        $assignedUser = User::find($bugtrack->assigned_to);
        if ($assignedUser) {
            Mail::to($assignedUser->email)->send(new BugAssignedNotification($bugtrack));
        }
    }
    // Redirect after successful creation
    return redirect()->route('bugtrack.index', ['projectId' => $projectId]);
}



public function updateStatus(Request $request, $bugId)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|string|in:Open,In Progress,Closed',
        ]);

        // Find the bug by its ID
        $bugtrack = Bugtracking::findOrFail($bugId);

        // Update the status
        $bugtrack->status = $request->status;
        $bugtrack->save();

        // Return a JSON response indicating success
        return response()->json(['success' => true]);
    }

    public function view($projectId, $bugtrackId)
    {
        // Fetch the bugtrack by ID within the project
        $bugtrack = Bugtracking::with(['assignee', 'reporter'])
                                ->where('project_id', $projectId)
                                ->find($bugtrackId);
    
        if (!$bugtrack) {
            // Handle the case when the bugtrack is not found
            return redirect()->route('bugtrack.index', ['projectId' => $projectId])
                             ->with('error', 'Bugtrack not found.');
        }
    
        return view('bugtrack.read', [
            'projectId' => $projectId,
            'bugtrack' => $bugtrack,
        ]);
    }

    public function generateReport($projectId, $bugtrackId)
    {
         // Fetch project name based on projectId
        $project = Project::find($projectId);
        $projectName = $project ? $project->proj_name : 'Unknown Project'; 
        $bugtrack = Bugtracking::findOrFail($bugtrackId);

        // Add project name to the $bugtrack object
        $bugtrack->projectName = $projectName;

        $pdf = Pdf::loadView('reports.bugtrack', compact('bugtrack'));

        return $pdf->download('bugtrack_report_' . $bugtrack->id . '.pdf');
    }
    
    public function notify($projectId, $bugtrackId)
    {
        // Fetch the bugtrack and project details
        $bugtrack = Bugtracking::findOrFail($bugtrackId);
        $project = Project::find($projectId);
        $projectName = $project ? $project->proj_name : 'Unknown Project'; 
    
        // Add project name to the $bugtrack object
        $bugtrack->projectName = $projectName;
        $assignedUser = $bugtrack->assignee;
    
        // Send notification email to the assigned user
        if ($assignedUser) {
            Mail::to($assignedUser->email)->send(new BugDueSoonNotification($bugtrack));
        }
    
        // Redirect with a success message
        return redirect()->route('bugtrack.view', ['projectId' => $projectId, 'bugtrackId' => $bugtrackId])
                         ->with('success', 'Notification sent successfully.');
    }

    public function updateWeights(Request $request)
    {
        // Validate the request
        $request->validate([
            'severity_weight' => 'required|numeric|min:0|max:1',
            'status_weight' => 'required|numeric|min:0|max:1',
            'due_weight' => 'required|numeric|min:0|max:1',
        ]);

        // Update or create the weights record
        Bugscore::updateOrCreate(
            ['id' => 1], // Assuming a single record for weights
            [
                'severity_weight' => $request->severity_weight,
                'status_weight' => $request->status_weight,
                'due_weight' => $request->due_weight
            ]
        );

        // Return a JSON response indicating success
        return response()->json(['success' => true]);
    }
    public function calculateBugScore()
    {
        // Fetch all bugtracks that don't have a status of 'Closed'
        $bugtracks = Bugtracking::where('status', '!=', 'Closed')->get();
    
        // Define scoring for severity
        $severityScores = [
            'low' => 1,
            'medium' => 2,
            'high' => 3
        ];
    
        // Define scoring for status
        $statusScores = [
            'open' => 1,
            'In Progress' => 2
        ];
    
        // Fetch dynamic weights from the database
        $weights = Bugscore::latest()->first();
    
        // Default weights if no weights are set
        $weights = $weights ?: (object)[
            'severity_weight' => 0.4,
            'status_weight' => 0.3,
            'due_weight' => 0.3
        ];
    
        $today = time();
    
        // Array to hold scores for all bugtracks
        $results = [];
    
        foreach ($bugtracks as $bugtrack) {
            // Calculate due date score
            $dueDateScore = 0;
    
            if ($bugtrack->due_date) {
                $dueDate = strtotime($bugtrack->due_date);
                $daysUntilDue = ($dueDate - $today) / (60 * 60 * 24);
    
                $dueDateScore = $daysUntilDue <= 3 ? 3 :
                                ($daysUntilDue > 3 && $daysUntilDue <= 10 ? 2 : 1);
            } else {
                // Default due date score if due_date is null
                $dueDateScore = 1; // Adjust this default value if needed
            }
    
            // Assign scores based on the properties
            $severityScore = $severityScores[strtolower($bugtrack->severity)] ?? 0;
            $statusScore = $statusScores[$bugtrack->status] ?? 0;
    
            // Calculate total score based on weights
            $totalScore = ($severityScore * $weights->severity_weight) +
                          ($statusScore * $weights->status_weight) +
                          ($dueDateScore * $weights->due_weight);
    
            // Add the result to the array
            $results[] = [
                'id' => $bugtrack->id,
                'severity' => $bugtrack->severity,
                'severity_score' => $severityScore,
                'status' => $bugtrack->status,
                'status_score' => $statusScore,
                'due_date' => $bugtrack->due_date,
                'due_date_score' => $dueDateScore,
                'total_score' => $totalScore
            ];
        }
    
         // Sort results by total score in descending order
    usort($results, function ($a, $b) {
        return $b['total_score'] <=> $a['total_score'];
    });
        // Return the results for debugging
        dd($results);
    }
    

}
