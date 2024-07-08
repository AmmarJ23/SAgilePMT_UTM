@extends('layouts.app2')

@section('title', 'Forum Create')
@section('content')
<div class="container mt-8 p-8 bg-white rounded-lg shadow-sm">
    <h1 class="text-center mb-8">Create a New Forum</h1>
    <form action="{{ route('forum.store', ['projectId' => $projectId]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-4">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter the forum title" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label for="content" class="form-label">Content</label>
            <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="6" maxlength="500" placeholder="Enter the forum content (Max 500 characters)" required></textarea>
            <small id="charCount" class="form-text text-muted">0/500 characters</small>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-control @error('category') is-invalid @enderror" required>
                <option value="" disabled selected>Select a category</option>
                <option value="General Discussion">General Discussion</option>
                <option value="Announcements">Announcements</option>
                <option value="Project Planning">Project Planning</option>
                <option value="Development">Development</option>
                <option value="Design">Design</option>
                <option value="Deployment">Deployment</option>
                <option value="Feature Requests">Feature Requests</option>
                <option value="Feedback">Feedback</option>
                <option value="Documentation">Documentation</option>
                <option value="Support">Support</option>
                <option value="Off-Topic">Off-Topic</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-4">
            <label for="image_urls" class="form-label">Image URL</label>
            <input type="text" id="image_urls" name="image_urls" class="form-control @error('image_urls') is-invalid @enderror" placeholder="Enter the image URL (optional)">
            @error('image_urls')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mr-3">
                <i class="fas fa-pen mr-2"></i> Create Forum
            </button>
            <a href="{{ route('forum.index', ['projectId' => $projectId]) }}" class="btn btn-secondary">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript to count characters -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contentTextarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');

        contentTextarea.addEventListener('input', function () {
            charCount.textContent = `${this.value.length}/500 characters`;
        });
    });
</script>
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
@endsection
