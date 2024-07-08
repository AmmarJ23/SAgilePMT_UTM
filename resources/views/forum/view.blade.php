@extends('layouts.app2')

@section('title', 'Forum View')

@section('content')
<div class="container mt-8 p-4 bg-white rounded-lg shadow-sm">
    <a href="{{ route('forum.index', ['projectId' => $projectId]) }}" class="text-blue-600 hover:underline block mb-4">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </a>

    <div class="mb-4 d-flex justify-content-end">
        @if(auth()->user() && auth()->user()->id === $forumPost->user_id)
            <a href="{{ route('forum.edit', ['forumPost' => $forumPost]) }}" style="background-color: #3f58b0; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 1rem; font-weight: 600; text-decoration: none; transition: background-color 0.3s ease-in-out;">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        @endif
    </div>

    <div style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <div style="padding: 20px;">
            <h1 style="font-size: 2.25rem; font-weight: 600; margin-bottom: 24px;">{{ $forumPost->title }}</h1>
            
            <div style="display: flex; align-items: center; color: #666; font-size: 0.875rem; margin-bottom: 24px;">
                <div style="background-color: #3f58b0; padding: 8px; border-radius: 50%; color: white;">
                    <i class="fas fa-user-circle" style="font-size: 1.25rem;"></i>
                </div>
                <span style="margin-left: 8px; font-weight: 600;">{{ $forumPost->user->name }}</span>
                
                <div style="margin-left: 16px; display: flex; align-items: center;">
                    <div style="background-color: #3f58b0; padding: 8px; border-radius: 50%; color: white;">
                        <i class="far fa-clock" style="font-size: 1.25rem;"></i>
                    </div>
                    <span style="margin-left: 8px; font-weight: 600;">{{ $forumPost->created_at->format('F d, Y h:i A') }}</span>
                </div>
                
                <div style="margin-left: 16px; display: flex; align-items: center;">
                    <div style="background-color: #3f58b0; padding: 8px; border-radius: 50%; color: white;">
                        <i class="fas fa-tag" style="font-size: 1.25rem;"></i>
                    </div>
                    <span style="margin-left: 8px; font-weight: 600;">{{ $forumPost->category }}</span>
                </div>
            </div>
    
            <div style="color: #333; font-size: 1.125rem; line-height: 1.6;">{{ $forumPost->content }}</div>
    
            @if($forumPost->image_urls)
                <div style="margin-top: 16px;">
                    <img src="{{ $forumPost->image_urls }}" alt="Forum Image" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                </div>
            @endif
        </div>
    </div>

    <div style="border-top: 1px solid #ccc; padding-top: 1rem;">
        <div style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Comments</div>
    
        <div style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 1rem;">
            <div style="padding: 1rem;">
                <form method="POST" action="{{ route('comments.store', ['forum_id' => $forumPost->id]) }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <textarea name="content" style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; line-height: 1.5;" rows="3" placeholder="Type your comment here..." required></textarea>
                        @error('content')
                            <p style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" style="background-color: #3f58b0; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 1rem; font-weight: 600; transition: background-color 0.3s ease-in-out;">
                        <i class="fas fa-paper-plane mr-2"></i> Post Comment
                    </button>
                </form>
            </div>
        </div>
    
        <div id="commentSection">
            @foreach($forumPost->comments as $comment)
                <div style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 1rem;">
                    <div style="padding: 1rem;">
                        <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                            <div style="background-color: #3f58b0; padding: 0.5rem; border-radius: 50%; color: white;">
                                <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i>
                            </div>
                            <div style="margin-left: 0.75rem;">
                                <span style="font-weight: 600;">{{ $comment->user->name }}</span>
                                <span style="color: #666; margin-left: 0.5rem;">{{ $comment->created_at->format('F d, Y h:i A') }}</span>
                            </div>
                        </div>
                        <p style="color: #333; font-size: 1.125rem; line-height: 1.6;">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<!-- Include SweetAlert2 just before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('load', () => {
        // Check for a success message in the session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
            });
        @endif
    });
</script>

<style>
    /* Custom CSS styles */
    .text-red-500 {
        color: #e53e3e; /* Red color for error text */
    }
</style>

@endsection
