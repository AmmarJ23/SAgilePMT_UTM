<!-- tasks.viewkanban.blade.php -->
@extends('layouts.app')

@section('content')
@include('inc.title')
    <div class="md:mx-4 relative overflow-hidden">
        <main class="h-full flex flex-col overflow-auto">
            <div class="kanban-board">
                <!-- Displaying tasks -->
                <div class="tasks">
                    @foreach($tasks as $task)
                        <div class="task" data-task-id="{{ $task->id }}">
                            <h3>{{ $task->title }}</h3>
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <!-- Script for handling task click and fetching description -->
    <script>
        document.querySelectorAll('.task').forEach(function (task) {
            task.addEventListener('click', function () {
                var taskId = task.getAttribute('data-task-id');
                fetch(`/tasks/${taskId}/description`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.description) {
                            // Show the task description (customize this based on your UI)
                            alert(data.description);
                        } else {
                            alert('Task description not available.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to fetch task description.');
                    });
            });
        });
    </script>
@endsection
