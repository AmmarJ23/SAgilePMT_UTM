<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bugtracking;
use App\User;
use App\Mail\BugAssignedNotification;
use Illuminate\Support\Facades\Mail;

class BugtrackingController extends Controller
{

    public function index()
{
    // Fetch all bugtrackings from the database
    $bugtracks = Bugtracking::all();

    // Get unique statuses from bugtrackings
    $statuses = $bugtracks->unique('status')->pluck('status');

    // Return the view with bugtracks data, statuses, and users
    return view('bugtrack.index', compact('bugtracks', 'statuses'));
}


public function create()
{
    // Fetch all users from the database
    $users = User::all();

    // Get the authenticated user
    $authUser = auth()->user();

    // Return the view with users data and authenticated user
    return view('bugtrack.create', compact('users', 'authUser'));
}


public function store(Request $request)
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
        'attachment' => 'nullable|string',
        'assigned_to' => 'nullable|integer',
    ]);

    // Set the reported_by field to the authenticated user's ID
    $validatedData['reported_by'] = auth()->user()->id;

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
    return redirect()->route('bugtrack.index')->with('success', 'Bug created successfully');
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

    public function details($id)
{
    // Fetch the bugtrack item from the database
    $bugtrack = Bugtracking::findOrFail($id);

    // Return the detailed information as JSON
    return response()->json([
        'title' => $bugtrack->title,
        'description' => $bugtrack->description,
        'assigned_to' => $bugtrack->assigned_to,
        // Add more fields as needed
    ]);
}

}
