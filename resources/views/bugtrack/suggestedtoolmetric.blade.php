@extends('layouts.app2')

@section('title', 'Update Weightage Suggested Tool')

@section('content')
<div class="container-fluid bg-light min-vh-100 d-flex flex-column p-4">
    <header class="bg-warning text-dark py-4 text-center mb-4 rounded shadow-sm">
        <h1 class="display-4">
            <i class="fas fa-tools mr-3"></i> Update Weightage Suggested Tool
        </h1>
    </header>
    <main class="flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="w-75"> <!-- Adjusted width -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('bugtrack.updateScore', ['projectId' => $projectId]) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
                @csrf
                <div class="mb-3">
                    <label for="severity_weight" class="form-label">Severity Weight</label>
                    <input type="number" class="form-control" id="severity_weight" name="severity_weight" required min="0" step="0.1" value="{{ old('severity_weight', $weights->severity_weight) }}">
                </div>
                <div class="mb-3">
                    <label for="status_weight" class="form-label">Status Weight</label>
                    <input type="number" class="form-control" id="status_weight" name="status_weight" required min="0" step="0.1" value="{{ old('status_weight', $weights->status_weight) }}">
                </div>
                <div class="mb-3">
                    <label for="due_weight" class="form-label">Due Weight</label>
                    <input type="number" class="form-control" id="due_weight" name="due_weight" required min="0" step="0.1" value="{{ old('due_weight', $weights->due_weight) }}">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm mx-2">Submit</button>
                    <a href="{{ route('bugtrack.index', ['projectId' => $projectId]) }}" class="btn btn-secondary btn-sm mx-2">
                        <i class="fas fa-times mr-2"></i> Go back
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection

<!-- Custom CSS -->
<style>
    .btn-primary, .btn-secondary {
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .form-control {
        max-width: 300px;
        margin: 0 auto;
    }

    .form-label {
        text-align: center;
        display: block;
    }

    .alert {
        max-width: 600px;
        margin: 10px auto;
    }

    @media (min-width: 768px) {
        .container-fluid {
            max-width: 750px;
        }
    }

    @media (min-width: 992px) {
        .container-fluid {
            max-width: 970px;
        }
    }

    @media (min-width: 1200px) {
        .container-fluid {
            max-width: 1170px;
        }
    }
</style>
