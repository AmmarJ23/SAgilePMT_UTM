<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bugtracking;
use App\User;
use App\Mail\BugAssignedNotification;
use Illuminate\Support\Facades\Mail;

class BugtrackingController extends Controller
{

    public function index(Request $request, $projectId)
{
    // Fetch all bugtrackings for the specified project from the database
    $bugtracks = Bugtracking::where('project_id', $projectId)->get();

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
    ]);

    // Set the reported_by field to the authenticated user's ID
    $validatedData['reported_by'] = auth()->user()->id;

    // Add projectId to the validated data
    $validatedData['project_id'] = $projectId;

    // Create new Bugtrack instance
    $bugtrack = Bugtracking::create($validatedData);

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
    
    

}
