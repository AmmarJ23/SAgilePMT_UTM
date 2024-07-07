@extends('layouts.app2')

@section('title', 'Bug Create')
@section('content')
<div class="container mx-auto mt-8 p-8 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-semibold mb-8 text-center">Create a New Bugtrack</h1>
    <form action="{{ route('bugtrack.store', ['projectId' => $projectId]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-gray-700 text-lg font-semibold mb-2">Title <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" class="form-input" placeholder="Enter the bug title" required autofocus>
        </div>
        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-lg font-semibold mb-2">Description <span class="text-red-500">*</span></label>
            <textarea id="description" name="description" class="form-textarea h-40 resize-none" placeholder="Enter the bug description" required autofocus></textarea>
            <p class="text-gray-500 text-sm mt-2">Max 500 characters</p>
        </div>
        <!-- Severity and Status -->
        <div class="flex mb-6">
            <div class="w-1/2 pr-4">
                <label for="severity" class="block text-gray-700 text-lg font-semibold mb-2">Severity</label>
                <select id="severity" name="severity" class="form-select" required>
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="w-1/2 pl-4">
                <label for="status" class="block text-gray-700 text-lg font-semibold mb-2">Status</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="open" selected>Open</option>
                    <option value="closed">Closed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
        <!-- Flow -->
        <div class="mb-6">
            <label for="flow" class="block text-gray-700 text-lg font-semibold mb-2">Flow</label>
            <input type="text" id="flow" name="flow" class="form-input" placeholder="Enter the bug flow">
        </div>
        <!-- Expected Results -->
        <div class="mb-6">
            <label for="expected_results" class="block text-gray-700 text-lg font-semibold mb-2">Expected Results</label>
            <textarea id="expected_results" name="expected_results" class="form-textarea h-32 resize-none" placeholder="Enter the expected results" required autofocus></textarea>
        </div>
        <!-- Actual Results -->
        <div class="mb-6">
            <label for="actual_results" class="block text-gray-700 text-lg font-semibold mb-2">Actual Results</label>
            <textarea id="actual_results" name="actual_results" class="form-textarea h-32 resize-none" placeholder="Enter the actual results" required autofocus></textarea>
        </div>
        <!-- Assigned To and Reported By -->
        <div class="flex mb-6">
            <div class="w-1/2 pr-4">
                <label for="assigned_to" class="block text-gray-700 text-lg font-semibold mb-2">Assigned To</label>
                <select id="assigned_to" name="assigned_to" class="form-select" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/2 pl-4">
                <label for="reported_by" class="block text-gray-700 text-lg font-semibold mb-2">Reported By</label>
                <input type="text" id="reported_by" name="reported_by" class="form-input" value="{{ $authUser->name }}" disabled>
                <input type="hidden" name="reported_by" value="{{ $authUser->name }}">
            </div>
        </div>
        <!-- Submit Button -->
        <br>
        <div class="flex justify-center mt-8 space-x-4">
            <button type="submit" class="btn-primary">
                <i class="fas fa-check mr-2"></i> Create Bugtrack
            </button>
            <a href="{{ route('bugtrack.index', ['projectId' => $projectId]) }}" class="btn-secondary">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript to count characters -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const descriptionTextarea = document.getElementById('description');
        const expectedResultsTextarea = document.getElementById('expected_results');
        const actualResultsTextarea = document.getElementById('actual_results');

        descriptionTextarea.addEventListener('input', function () {
            document.getElementById('charCountDescription').textContent = this.value.length;
        });

        expectedResultsTextarea.addEventListener('input', function () {
            document.getElementById('charCountExpectedResults').textContent = this.value.length;
        });

        actualResultsTextarea.addEventListener('input', function () {
            document.getElementById('charCountActualResults').textContent = this.value.length;
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const descriptionTextarea = document.getElementById('description');
        const charLimit = 500;
        const successMessage = document.createElement('div');
        successMessage.className = 'success-message';
        successMessage.textContent = 'Bugtrack created successfully!';
        successMessage.style.display = 'none';

        form.addEventListener('submit', function (e) {
            let valid = true;
            const descriptionLength = descriptionTextarea.value.length;

            // Clear previous validation messages
            document.querySelectorAll('.validation-error').forEach(el => el.remove());

            // Check required fields
            form.querySelectorAll('[required]').forEach(function (input) {
                if (!input.value) {
                    valid = false;
                    showValidationError(input, 'This field is required.');
                }
            });

            // Validate description length
            if (descriptionLength > charLimit) {
                valid = false;
                showValidationError(descriptionTextarea, `Description must be less than ${charLimit} characters.`);
            }

            if (!valid) {
                e.preventDefault();
            } else {
                successMessage.style.display = 'block';
                document.body.appendChild(successMessage);
            }
        });

        function showValidationError(element, message) {
            const error = document.createElement('div');
            error.className = 'validation-error text-red-500 text-sm mt-2';
            error.textContent = message;
            element.parentNode.appendChild(error);
        }
    });
</script>


<!-- Custom CSS -->
<style>
    /* Form Input Styles */
    .form-input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #d2d6dc;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-input:focus {
        outline: 0;
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }

    /* Form Textarea Styles */
    .form-textarea {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #d2d6dc;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        resize: vertical;
    }

    .form-textarea:focus {
        outline: 0;
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }

    /* Form Select Styles */
    .form-select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #d2d6dc;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23363f4a' viewBox='0 0 20 20'%3e%3cpath d='M10 12l-8-8H1l9 9 9-9h-1l-8 8z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5em 1.5em;
    }

    .form-select:focus {
        outline: 0;
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }

    /* Button Styles */
    .btn-primary {
        display: inline-block;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.5rem;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary {
        display: inline-block;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.5rem;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
        color: #333;
        background-color: transparent;
        border-color: #ccc;
    }

    .btn-secondary:hover {
        color: #333;
        background-color: #f0f0f0;
        border-color: #ccc;
    }

    .validation-error {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Success Message Styles */
.success-message {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #48bb78;
    color: white;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    font-weight: 600;
    z-index: 1000;
}
</style>
@endsection
