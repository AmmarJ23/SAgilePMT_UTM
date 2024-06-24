@extends('layouts.app2')

@section('title', 'Bugtracking')

@section('content')
<div class="flex flex-col min-h-screen bg-light-blue">
    <!-- Header -->
    <header class="bg-navy-blue text-blue py-4 text-center mb-4 rounded-lg">
        <h1 class="text-4xl font-extrabold flex items-center justify-center">
            <i class="fas fa-bug mr-2"></i> Bugtracking
        </h1>
    </header>

    <!-- Main Content -->
    <div class="flex-grow flex">
        <!-- Left Sidebar for Create Button -->
        <aside class="w-1/4 p-4">
            <div class="mb-4">
                <a href="{{ route('bugtrack.create') }}" class="btn btn-primary w-full mb-2">
                    <i class="fas fa-bug"></i> Create Bugtrack
                </a>
            </div>
        </aside>

        <!-- Right Section for Bugtrackings -->
        <main class="w-3/4 pl-4 flex-grow flex flex-col">
            <!-- Section for "Open" bugtrackings -->
            <div class="w-full p-4">
                <div class="card mb-4 rounded-lg shadow-md">
                    <div class="card-body">
                        <h2 class="text-2xl font-semibold mb-4">Open</h2>
                        <div class="droppable" data-status="open">
                            @forelse($bugtracks as $bugtrack)
                                @if($bugtrack->status === 'open')
                                    <div class="bugtrack-card card mb-4 rounded-lg shadow-md draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                        <div class="card-body">
                                            <h3 class="text-xl font-semibold">{{ $bugtrack->title }}</h3>
                                            <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                            <div class="flex items-center text-gray-600 text-sm mt-2">
                                                <!-- Additional information -->
                                            </div>
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
            <div class="w-full p-4">
                <div class="card mb-4 rounded-lg shadow-md">
                    <div class="card-body">
                        <h2 class="text-2xl font-semibold mb-4">In Progress</h2>
                        <div class="droppable" data-status="In Progress">
                            @forelse($bugtracks as $bugtrack)
                                @if($bugtrack->status === 'In Progress')
                                    <div class="bugtrack-card card mb-4 rounded-lg shadow-md draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                        <div class="card-body">
                                            <h3 class="text-xl font-semibold">{{ $bugtrack->title }}</h3>
                                            <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                            <div class="flex items-center text-gray-600 text-sm mt-2">
                                                <!-- Additional information -->
                                            </div>
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
            <div class="w-full p-4">
                <div class="card mb-4 rounded-lg shadow-md">
                    <div class="card-body">
                        <h2 class="text-2xl font-semibold mb-4">Closed</h2>
                        <div class="droppable" data-status="Closed">
                            @forelse($bugtracks as $bugtrack)
                                @if($bugtrack->status === 'Closed')
                                    <div class="bugtrack-card card mb-4 rounded-lg shadow-md draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                        <div class="card-body">
                                            <h3 class="text-xl font-semibold">{{ $bugtrack->title }}</h3>
                                            <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                            <div class="flex items-center text-gray-600 text-sm mt-2">
                                                <!-- Additional information -->
                                            </div>
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

    <!-- Sidebar for bugtrack details -->
    <aside id="bugtrack-details-sidebar" class="fixed inset-y-0 right-0 w-1/4 bg-white p-4 rounded-l-lg shadow-md hidden">
        <!-- Detailed bugtrack information will be displayed here -->
    </aside>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-3">
        &copy; {{ date('Y') }} Jeevan Bugtracking. All Rights Reserved.
    </footer>
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<!-- JavaScript for drag and drop and displaying detailed information -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bugtrackCards = document.querySelectorAll('.bugtrack-card');

        bugtrackCards.forEach(card => {
            card.addEventListener('click', () => {
                const bugId = card.dataset.id;

                // Fetch detailed information about the bugtrack item
                fetch(`/bugtrack/${bugId}/details`)
                    .then(response => response.json())
                    .then(data => {
                        // Display the detailed information in the sidebar
                        const sidebar = document.querySelector('#bugtrack-details-sidebar');
                        sidebar.innerHTML = `
                            <h3 class="text-xl font-semibold mb-2">${data.title}</h3>
                            <p class="text-gray-700 mb-4">${data.description}</p>
                            <p class="text-gray-600">Assigned to: ${data.assigned_to}</p>
                            <!-- Add more fields here as needed -->
                        `;

                        // Show the sidebar
                        sidebar.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

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
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        droppable.appendChild(draggable);
                        // Update the status in the UI if necessary
                    } else {
                        console.error('Failed to update bug status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endsection

<!-- Custom CSS -->
<style>
    /* Button Styles */
    .btn {
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
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #0056b3;
        border-color: #0056b3;
    }

    /* Card Styles */
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.5rem;
        transition: box-shadow 0.15s ease-in-out, border-color 0.15s ease-in-out;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.5rem;
    }

    /* Dragging Effect */
    .draggable.dragging {
        opacity: 0.5;
    }

    /* Droppable Area */
    .droppable {
        min-height: 100px; /* Adjust as needed */
        border: 2px dashed #ccc;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #f9f9f9;
    }
</style>
