@extends('layouts.app2')

@section('title', 'Bugtrack View')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Bugtrack Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 30%;">Name</th>
                                        <td>{{ $bugtrack->title }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Description</th>
                                        <td>{{ $bugtrack->description }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Due Date</th>
                                        <td>{{ $bugtrack->due_date }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td><strong>{{ $bugtrack->status }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Severity</th>
                                        <td>{{ ucfirst($bugtrack->severity) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>{{ ucfirst($bugtrack->status) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Flow</th>
                                        <td>{{ $bugtrack->flow }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Expected Results</th>
                                        <td>{{ $bugtrack->expected_results }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Actual Results</th>
                                        <td>{{ $bugtrack->actual_results }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Assigned To</th>
                                        <td>{{ $bugtrack->assignee->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Reported By</th>
                                        <td>{{ $bugtrack->reporter->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="text-center">
                            <a href="{{ route('bugtrack.index', ['projectId' => $projectId]) }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Go Back
                            </a>
                            <a href="{{ route('bugtrack.notify', ['projectId' => $projectId, 'bugtrackId' => $bugtrack->id]) }}" class="btn btn-warning">
                                <i class="fas fa-envelope"></i> Notify User
                            </a>
                            <a href="{{ route('bugtrack.generate', ['projectId' => $projectId, 'bugtrackId' => $bugtrack->id]) }}" class="btn btn-success">
                                <i class="fas fa-file-alt"></i> Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Custom CSS -->
<style>
    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: #007bff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        color: #fff;
    }

    .table th, .table td {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        vertical-align: top;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: normal;
        width: 30%;
    }

    .table td {
        background-color: #fff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
