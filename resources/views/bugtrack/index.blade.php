@extends('layouts.app2')

@section('title', 'Bugtracking')

@section('content')
<div class="container-fluid bg-light min-vh-100 d-flex flex-column p-4">
    <!-- Header -->
    <header class="bg-primary text-white py-4 text-center mb-4 rounded">
        <h1 class="display-4">
            <i class="fas fa-bug mr-3"></i> Bug Tracking
        </h1>
    </header>

  <!-- Main Content -->
  <div class="d-flex flex-grow-1">
    <!-- Left Sidebar for Create Button -->
    <aside class="col-3 p-4 bg-light border-right">
        <div class="mb-4">
            <!-- Link for creating new bugtrack with project ID -->
            <a href="{{ route('bugtrack.create', ['projectId' => $projectId]) }}" class="btn btn-primary btn-block mb-3">
                <i class="fas fa-bug"></i> Create Bugtrack
            </a>

            <!-- Filter Form -->
            <div class="mb-4">
                <label for="severity-filter" class="form-label">Filter by Severity</label>
                <select id="severity-filter" class="form-select mb-2">
                    <option value="">All Severities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                <label for="status-filter" class="form-label">Filter by Status</label>
                <select id="status-filter" class="form-select mb-2">
                    <option value="">All Statuses</option>
                    <option value="open">Open</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Closed">Closed</option>
                </select>
                <label for="search-bar" class="form-label">Search</label>
                <input type="text" id="search-bar" class="form-control" placeholder="Search...">
            </div>
        </div>
    </aside>
    <!-- JavaScript for filtering and searching -->



        <!-- Right Section for Bugtrackings -->
        <main class="col-9 pl-4 d-flex flex-column flex-grow-1">
            <!-- Success Message Element -->
            <div id="successMessage" class="alert alert-success d-none" role="alert">
                Bug status updated successfully.
            </div>

        <!-- Right Section for Bugtrackings -->
        <main class="col-9 pl-4 d-flex flex-column flex-grow-1">
            <!-- Section for "Open" bugtrackings -->
            <div class="mb-4">
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary text-white">
                        <h2 class="h4 font-weight-bold mb-0">Open</h2>
                    </div>
                    <div class="card-body">
                        <div class="droppable" data-status="open">
                            @forelse($bugtracks as $bugtrack)
                                @if($bugtrack->status === 'open')
                                <div class="bugtrack-card card mb-4 draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="h5 font-weight-bold">{{ $bugtrack->title }}</h3>
                                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                         <span>{{ $bugtrack->created_at->format('F j, Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-exclamation-circle mr-2 text-danger"></i>
                                                        <span class="text-danger">Severity:</span>
                                                        <span class="ml-2 badge badge-{{ $bugtrack->severity }}">{{ ucfirst($bugtrack->severity) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('bugtrack.view', ['projectId' => $projectId, 'bugtrackId' => $bugtrack->id]) }}" class="eye-icon">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <p>No bugtrackings found with status "Open".</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section for "In Progress" bugtrackings -->
            <div class="mb-4">
                <div class="card mb-4 border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h2 class="h4 font-weight-bold mb-0">In Progress</h2>
                    </div>
                    <div class="card-body">
                        <div class="droppable" data-status="In Progress">
                            @forelse($bugtracks as $bugtrack)
                                @if($bugtrack->status === 'In Progress')
                                <div class="bugtrack-card card mb-4 draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="h5 font-weight-bold">{{ $bugtrack->title }}</h3>
                                            <p class="text-muted">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                         <span>{{ $bugtrack->created_at->format('F j, Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-exclamation-circle mr-2 text-danger"></i>
                                                        <span class="text-danger">Severity:</span>
                                                        <span class="ml-2 badge badge-{{ $bugtrack->severity }}">{{ ucfirst($bugtrack->severity) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('bugtrack.view', ['projectId' => $projectId, 'bugtrackId' => $bugtrack->id]) }}" class="eye-icon">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                @endif
                            @empty
                                <p>No bugtrackings found with status "In Progress".</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section for "Closed" bugtrackings -->
            <div class="mb-4">
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <h2 class="h4 font-weight-bold mb-0">Closed</h2>
                    </div>
                    <div class="card-body">
                        <div class="droppable" data-status="Closed">
                            @forelse($bugtracks as $bugtrack)
                                @if($bugtrack->status === 'Closed')
                                    <div class="bugtrack-card card mb-4 draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <h3 class="h5 font-weight-bold">{{ $bugtrack->title }}</h3>
                                                <p class="text-muted">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="far fa-calendar-alt mr-1"></i>
                                                             <span>{{ $bugtrack->created_at->format('F j, Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-exclamation-circle mr-2 text-danger"></i>
                                                            <span class="text-danger">Severity:</span>
                                                            <span class="ml-2 badge badge-{{ $bugtrack->severity }}">{{ ucfirst($bugtrack->severity) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('bugtrack.view', ['projectId' => $projectId, 'bugtrackId' => $bugtrack->id]) }}" class="eye-icon">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p>No bugtrackings found with status "Closed".</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<!-- JavaScript for drag and drop and displaying detailed information -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bugtrackCards = document.querySelectorAll('.bugtrack-card');

        bugtrackCards.forEach(card => {
            card.addEventListener('dragstart', () => {
                card.classList.add('dragging');
            });

            card.addEventListener('dragend', () => {
                card.classList.remove('dragging');
            });
        });

        const droppables = document.querySelectorAll('.droppable');

        droppables.forEach(droppable => {
            droppable.addEventListener('dragover', e => {
                e.preventDefault();
            });

            droppable.addEventListener('drop', e => {
                const draggable = document.querySelector('.dragging');
                const status = droppable.dataset.status;
                const bugId = draggable.dataset.id;

                // Send AJAX request to update bug status
                fetch(`/bugtrack/${bugId}/update-status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status })
                })
                .then(response => {
                    if (response.ok) {
                        // Move the card to the new column
                        droppable.appendChild(draggable);
                        
                        // Display SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: `Bugtrack status has been updated to "${status}"`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        console.error('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const severityFilter = document.getElementById('severity-filter');
        const statusFilter = document.getElementById('status-filter');
        const searchBar = document.getElementById('search-bar');
        const bugtrackCards = document.querySelectorAll('.bugtrack-card');

        // Event listeners for filters
        severityFilter.addEventListener('change', filterBugtracks);
        statusFilter.addEventListener('change', filterBugtracks);
        searchBar.addEventListener('input', filterBugtracks);

        function filterBugtracks() {
            const severityValue = severityFilter.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const searchValue = searchBar.value.trim().toLowerCase();

            bugtrackCards.forEach(card => {
                const severity = card.querySelector('.badge').textContent.toLowerCase();
                const status = card.closest('.droppable').dataset.status.toLowerCase();
                const title = card.querySelector('.font-weight-bold').textContent.toLowerCase();
                const description = card.querySelector('.text-muted').textContent.toLowerCase();

                const matchesSeverity = severityValue === '' || severity.includes(severityValue);
                const matchesStatus = statusValue === '' || status.includes(statusValue);
                const matchesSearch = title.includes(searchValue) || description.includes(searchValue);

                if (matchesSeverity && matchesStatus && matchesSearch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection

<!-- Custom CSS -->
<style>
    /* Container and Sidebar Styles */
    .container-fluid {
        padding: 0;
    }

    .bg-light-blue {
        background-color: #f8f9fa;
    }

    .bg-primary {
        background-color: #007bff;
    }

    .bg-dark {
        background-color: #343a40;
    }

    .border-right {
        border-right: 1px solid #dee2e6;
    }

    .form-select,
    .form-control {
        margin-bottom: 0.5rem;
    }

    /* Button Styles */
    .btn {
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    /* Card Styles */
    .card {
        transition: box-shadow 0.15s ease-in-out, border-color 0.15s ease-in-out;
    }

    .badge-low {
        background-color: #28a745;
    }

    .badge-medium {
        background-color: #ffc107;
    }

    .badge-high {
        background-color: #dc3545;
    }

    /* Dragging Effect */
    .draggable.dragging {
        opacity: 0.5;
    }

    /* Droppable Area */
    /* .droppable {
        min-height: 100px;
        /* Adjust as needed */
        border: 2px dashed #ccc;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #f9f9f9;
    } */

    /* Bugtrack Details Sidebar */
    #bugtrack-details-sidebar {
        width: 25%;
        right: 0;
        top: 0;
        bottom: 0;
        overflow-y: auto;
    }

    /* Success Message */
    #successMessage {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        display: none;
    }

    /* Footer */
    footer {
        background-color: #343a40;
        color: white;
        padding: 1rem;
    }
</style>
