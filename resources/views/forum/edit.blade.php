@extends('layouts.app2')

@section('title', 'Forum Edit')

@section('content')
<div class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow-md">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h1 style="font-size: 1.875rem; font-weight: 600; color: #1a202c;">
            <i class="fas fa-edit mr-2" style="color: #3f58b0;"></i> Edit Forum Post
        </h1>
        <a href="{{ route('forum.view', ['projectId' => $projectId, 'forumPostId' => $forumPost->id]) }}" style="color: #3f58b0; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left mr-1"></i> Back to Forum
        </a>
    </div>
    
    <form action="{{ route('forum.update', $forumPost->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1rem;">
            <label for="updatedContent" style="display: block; color: #4a5568; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">
                <i class="fas fa-pencil-alt mr-2" style="color: #3f58b0;"></i> Content
            </label>
            <textarea id="updatedContent" name="updatedContent" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e0; border-radius: 0.375rem; resize: none; font-size: 1rem; line-height: 1.5;" rows="8" maxlength="500" required>{{ $forumPost->content }}</textarea>
        </div>
        <div style="text-align: right;">
            <button type="submit" style="background-color: #3f58b0; color: #fff; padding: 0.75rem 1.5rem; border: none; border-radius: 0.375rem; cursor: pointer; font-size: 1rem; font-weight: 600; transition: background-color 0.3s ease-in-out;">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
    
    <div style="text-align: right; margin-top: 1rem;">
        <a href="{{ route('forum.view', ['projectId' => $projectId, 'forumPostId' => $forumPost->id]) }}" class="btn btn-outline-danger">
            <i class="fas fa-arrow-left mr-2"></i> Back to Forum
        </a>
    </div>
    
    @error('updatedContent')
    <span style="color: #e53e3e; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
    @enderror
</div>

<!-- Include SweetAlert2 just before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('load', () => {
        // Check for a success message in the session
        const successMessage = "{{ session('success') }}";

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage,
            });
        }
    });
</script>
@endsection
