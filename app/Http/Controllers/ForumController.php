<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;
use Illuminate\Support\Facades\Auth;


class ForumController extends Controller
{
    public function index(Request $request, $projectId)
{
    $categoryFilter = $request->input('category'); // Get the selected category from the request

    // Query forums based on the selected category and project ID, or fetch all if no category is selected
    $forumPosts = Forum::where('project_id', $projectId)
        ->when($categoryFilter, function ($query) use ($categoryFilter) {
            return $query->where('category', $categoryFilter);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('forum.index', [
        'forumPosts' => $forumPosts,
        'selectedCategory' => $categoryFilter, // Pass the selected category to the view
        'projectId' => $projectId, // Pass the project ID to the view
    ]);
}


public function view($projectId, $forumPostId)
{
    // Fetch the forum post by ID within the project
    $forumPost = Forum::where('project_id', $projectId)->find($forumPostId);

    if (!$forumPost) {
        // Handle the case when the forum post is not found
        return redirect()->route('forum.index', ['projectId' => $projectId])->with('error', 'Forum post not found.');
    }

    return view('forum.view', [
        'projectId' => $projectId,
        'forumPost' => $forumPost,
    ]);
}

    
public function create($projectId = null)
{
    return view('forum.create', ['projectId' => $projectId]);
}


public function store(Request $request, $projectId)
{
    // Validation rules
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'required|string', // Assuming you have a category field
        'image_urls' => 'nullable|string', // Validate image URL as a valid URL
        // Add any other validation rules you need
    ]);

    // Get the authenticated user's ID
    $userId = Auth::id();

    // Create the forum post including the project ID and user ID
    Forum::create([
        'title' => $validatedData['title'],
        'content' => $validatedData['content'],
        'category' => $validatedData['category'],
        'image_urls' => $validatedData['image_urls'],
        'project_id' => $projectId,
        'user_id' => $userId,
    ]);

    // Redirect or return response as needed
    return redirect()->route('forum.index', $projectId)->with('success', 'Forum post created successfully!');
}


public function update(Request $request, Forum $forumPost)
{
    // Validation and update logic here
    // You can access the forum post using $forumPost
    $forumPost->update(['content' => $request->input('updatedContent')]);

    // Redirect back to the previous page (two pages ago)
    return redirect()->back()->with('success', 'Forum post updated successfully!');
}



public function edit($id)
{
    $forumPost = Forum::findOrFail($id); // Assuming you're fetching the forum post by ID

    // Assuming $projectId is fetched from somewhere, adjust this as per your application logic
    $projectId = $forumPost->project_id;

    return view('forum.edit', compact('forumPost', 'projectId'));
}

public function destroy(Forum $forumPost)
{
    // Perform validation or authorization checks here, if needed.

    // Delete the forum post.
    $forumPost->delete();

    return redirect()->route('forum.index')->with('success', 'Forum post deleted successfully');

}





}



