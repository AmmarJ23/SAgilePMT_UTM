<!-- Main Task Page -->
@extends('layouts.app2')
@include('inc.style')
@include('inc.success')
@include('inc.dashboard')
@include('inc.navbar')

@section('content')
    @include('inc.title')
    <div id="calendar"></div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/fullcalendar.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    @foreach($tasks as $task)
                        {
                            title: '{{ $task->title }}',
                            start: '{{ $task->start_date }}', // Adjust property names according to your task properties
                            end: '{{ $task->end_date }}',
                            url: '{{ route('tasks.edit', [$task->id]) }}' // Link to edit task
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // Prevent browser navigation
                    window.location.href = info.event.url; // Redirect to task edit page
                }
            });
            calendar.render();
        });
    </script>
@endsection