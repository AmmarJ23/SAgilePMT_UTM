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
    
            <div style="color: #333; font-size: 1.125rem; line-height: 1.6;">{!! $forumPost->content !!}</div>
    
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
                        <div id="editor" style="height: 200px; background-color: white;"></div>
                        <input type="hidden" name="content" id="content">
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
                <div style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 1rem;" id="comment-{{ $comment->id }}">
                    <div style="padding: 1rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                            <div style="display: flex; align-items: center;">
                                <div style="background-color: #3f58b0; padding: 0.5rem; border-radius: 50%; color: white;">
                                    <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i>
                                </div>
                                <div style="margin-left: 0.75rem;">
                                    <span style="font-weight: 600;">{{ $comment->user->name }}</span>
                                    <span style="color: #666; margin-left: 0.5rem;">{{ $comment->created_at->format('F d, Y h:i A') }}</span>
                                </div>
                            </div>
                            <div>
                                @if(auth()->user() && auth()->user()->id === $comment->user_id)
                                    <button class="edit-comment-btn" data-comment-id="{{ $comment->id }}" style="margin-right: 10px; background: none; border: none; cursor: pointer; color: #3f58b0;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete-comment-btn" data-comment-id="{{ $comment->id }}" style="background: none; border: none; cursor: pointer; color: #e53e3e;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                                <button class="reply-comment-btn" data-comment-id="{{ $comment->id }}" style="background: none; border: none; cursor: pointer; color: #3f58b0;">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            </div>
                        </div>
                        <div class="comment-content" id="comment-content-{{ $comment->id }}">
                            {!! $comment->content !!}
                        </div>

                      <!-- Replies Section -->
                <div class="replies-section mt-3">
                    @foreach($comment->replies as $reply)
                        <div class="reply" id="reply-{{ $reply->id }}" style="border-left: 2px solid #3f58b0; padding-left: 1rem; margin-top: 0.75rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                                <div style="display: flex; align-items: center;">
                                    <div style="background-color: #3f58b0; padding: 0.5rem; border-radius: 50%; color: white;">
                                        <i class="fas fa-user-circle" style="font-size: 1.25rem;"></i>
                                    </div>
                                    <div style="margin-left: 0.75rem;">
                                        <span style="font-weight: 600;">{{ $reply->user->name }}</span>
                                        <span style="color: #666; margin-left: 0.5rem;">{{ $reply->created_at->format('F d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div>
                                    @if(auth()->user() && auth()->user()->id === $reply->user_id)
                                        <button class="edit-reply-btn" data-reply-id="{{ $reply->id }}" style="margin-right: 10px; background: none; border: none; cursor: pointer; color: #3f58b0;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="delete-reply-btn" data-reply-id="{{ $reply->id }}" style="background: none; border: none; cursor: pointer; color: #e53e3e;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="reply-content" id="reply-content-{{ $reply->id }}">
                                {!! $reply->content !!}
                            </div>
                        </div>
                    @endforeach
                </div>

                        <!-- Reply Form -->
                        <div class="reply-form mt-3" id="reply-form-{{ $comment->id }}" style="display: none;">
                            <form method="POST" action="{{ route('comments.reply', ['id' => $comment->id]) }}">
                                @csrf
                                <div style="margin-bottom: 1rem;">
                                    <div id="editor-reply-{{ $comment->id }}" style="height: 100px; background-color: white;"></div>
                                    <input type="hidden" name="content" id="content-reply-{{ $comment->id }}">
                                    @error('content')
                                        <p style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" style="background-color: #3f58b0; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 1rem; font-weight: 600; transition: background-color 0.3s ease-in-out;">
                                    <i class="fas fa-paper-plane mr-2"></i> Post Reply
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<!-- Quillbot JS and CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
                timer: 3000, // Auto close after 3 seconds
                showConfirmButton: false // Hide the OK button
            });
        @endif

        // Check for an error message in the session
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                timer: 3000, // Auto close after 3 seconds
                showConfirmButton: false // Hide the OK button
            });
        @endif

        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        var form = document.querySelector('form');
        form.onsubmit = function() {
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        };

        // Event listeners for edit and delete buttons
        document.querySelectorAll('.edit-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                editComment(commentId);
            });
        });

        document.querySelectorAll('.delete-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                deleteComment(commentId);
            });
        });

        document.querySelectorAll('.edit-reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const replyId = this.getAttribute('data-reply-id');
                editComment(replyId);
            });
        });

        document.querySelectorAll('.delete-reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const replyId = this.getAttribute('data-reply-id');
                deleteComment(replyId);
            });
        });

        document.querySelectorAll('.reply-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                replyToComment(commentId);
            });
        });

    });

    function editComment(commentId) {
        const content = document.getElementById(`comment-content-${commentId}`).innerHTML;
        Swal.fire({
            title: 'Edit Comment',
            html: `<textarea id="edit-comment-textarea" class="swal2-textarea" style="display: block; width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 0.375rem;">${content}</textarea>`,
            focusConfirm: false,
            preConfirm: () => {
                const editedContent = document.getElementById('edit-comment-textarea').value;
                return { content: editedContent };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const editedContent = result.value.content;
                axios.post(`/comments/${commentId}/update`, {
                    content: editedContent,
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    if (response.data.success) {
                        document.getElementById(`comment-content-${commentId}`).innerHTML = editedContent;
                        Swal.fire('Success', response.data.message, 'success');
                    } else {
                        Swal.fire('Error', response.data.message, 'error');
                    }
                }).catch(error => {
                    Swal.fire('Error', 'An error occurred while updating the comment.', 'error');
                });
            }
        });
    }

    function deleteComment(commentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/comments/${commentId}/delete`, {
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    if (response.data.success) {
                        document.getElementById(`comment-${commentId}`).remove();
                        Swal.fire('Deleted!', response.data.message, 'success');
                    } else {
                        Swal.fire('Error', response.data.message, 'error');
                    }
                }).catch(error => {
                    Swal.fire('Error', 'An error occurred while deleting the comment.', 'error');
                });
            }
        });
    }

    function replyToComment(commentId) {
        Swal.fire({
            title: 'Reply to Comment',
            html: `<textarea id="reply-comment-textarea-${commentId}" class="swal2-textarea" style="display: block; width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 0.375rem;"></textarea>`,
            focusConfirm: false,
            preConfirm: () => {
                const replyContent = document.getElementById(`reply-comment-textarea-${commentId}`).value;
                return replyContent.trim(); // Ensure the content is trimmed before sending
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const replyContent = result.value;
                axios.post(`/comments/${commentId}/reply`, {
                    content: replyContent,
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    if (response.data.success) {
                        Swal.fire('Success', response.data.message, 'success');
                        // Optionally, you can update the UI to display the new reply
                        // For example, append the new reply to the comment section
                        const replyHtml = `
                            <div class="reply" style="border-left: 2px solid #3f58b0; padding-left: 1rem; margin-top: 0.75rem;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <div style="display: flex; align-items: center;">
                                        <div style="background-color: #3f58b0; padding: 0.5rem; border-radius: 50%; color: white;">
                                            <i class="fas fa-user-circle" style="font-size: 1.25rem;"></i>
                                        </div>
                                        <div style="margin-left: 0.75rem;">
                                            <span style="font-weight: 600;">{{ auth()->user()->name }}</span>
                                            <span style="color: #666; margin-left: 0.5rem;">Now</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="reply-content">
                                    ${replyContent}
                                </div>
                            </div>
                        `;
                        document.getElementById(`reply-form-${commentId}`).style.display = 'none'; // Hide the reply form
                        document.getElementById(`comment-${commentId}`).getElementsByClassName('replies-section')[0].innerHTML += replyHtml; // Append new reply
                    } else {
                        Swal.fire('Success', response.data.message, 'success');
                    }
                }).catch(error => {
                    console.error('Error:', error); // Log the error to console for debugging
                    Swal.fire('Error', 'An error occurred while replying to the comment.', 'error');
                });
            }
        }).catch((error) => {
            console.error('Error:', error); 
            console.error('Swal error:', error); // Log the SweetAlert error to console
        });
        
    }
    


    function editReply(commentId) {
        const content = document.getElementById(`comment-content-${replyId}`).innerHTML;
        Swal.fire({
            title: 'Edit Comment',
            html: `<textarea id="edit-comment-textarea" class="swal2-textarea" style="display: block; width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 0.375rem;">${content}</textarea>`,
            focusConfirm: false,
            preConfirm: () => {
                const editedContent = document.getElementById('edit-comment-textarea').value;
                return { content: editedContent };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const editedContent = result.value.content;
                axios.post(`/comments/${replyId}/update`, {
                    content: editedContent,
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    if (response.data.success) {
                        document.getElementById(`comment-content-${replyId}`).innerHTML = editedContent;
                        Swal.fire('Success', response.data.message, 'success');
                    } else {
                        Swal.fire('Error', response.data.message, 'error');
                    }
                }).catch(error => {
                    Swal.fire('Error', 'An error occurred while updating the comment.', 'error');
                });
            }
        });
    }

    function deleteReply(replyId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(`/comments/${replyId}/delete`, {
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    if (response.data.success) {
                        document.getElementById(`comment-${reply}`).remove();
                        Swal.fire('Deleted!', response.data.message, 'success');
                    } else {
                        Swal.fire('Error', response.data.message, 'error');
                    }
                }).catch(error => {
                    Swal.fire('Error', 'An error occurred while deleting the reply.', 'error');
                });
            }
        });
    }
</script>
@endsection
