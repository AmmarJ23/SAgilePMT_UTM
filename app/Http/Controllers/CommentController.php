<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Forum;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class CommentController extends Controller
{
    public function store(Request $request, $forum_id)
    {
        // Validate the request data as needed
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);
    
        // Create a new comment with the user_id set to the currently authenticated user
        $comment = new Comment([
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
            'forum_id' => $forum_id, // Pass the forum_id here
        ]);
    
        // Save the comment
        $comment->save();
    
        // Redirect back to the forum post view page
        return back()->with('success', 'Comment added successfully!');
    }
    
    public function replyToComment(Request $request, $comment_id, $forum_id)
{
    $validatedData = $request->validate([
        'content' => 'required|string',
    ]);

    $comment = Comment::findOrFail($comment_id);
    $reply = new Comment();
    $reply->content = $validatedData['content'];
    $reply->user_id = auth()->id(); // Assuming you're using authentication
    $reply->parent_id = $comment->id;
    $reply->parent_id =  $forum_id;// Set the parent_id to the original comment's ID
    $reply->save();

    return redirect()->back()->with('success', 'Reply posted successfully.');
}

public function update(Request $request, $commentId)
{
    $request->validate([
        'content' => 'required'
    ]);

    $comment = Comment::findOrFail($commentId);

    if ($comment->user_id !== Auth::id()) {
        return response()->json(['success' => false, 'message' => 'You are not authorized to update this comment.']);
    }

    $comment->update([
        'content' => $request->input('content')
    ]);

    return response()->json(['success' => true, 'message' => 'Comment updated successfully.']);
}

public function delete($commentId)
{
    $comment = Comment::findOrFail($commentId);

    if ($comment->user_id !== Auth::id()) {
        return response()->json(['success' => false, 'message' => 'You are not authorized to delete this comment.']);
    }

    $comment->delete();

    return response()->json(['success' => true, 'message' => 'Comment deleted successfully.']);
}
}
