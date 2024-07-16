@extends('layouts.app2')
@include('inc.style')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('calendar.create') }}" class="btn btn-primary">Add Event</a>
            </div>
            <div id="calendar"></div>
        </div>
    </div>
</div>


<!-- Bootstrap Modal for Calendar Event Details -->
<div class="modal fade" id="calendarEventModal" tabindex="-1" aria-labelledby="calendarEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarEventModalLabel">Calendar Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> <span id="calendarEventTitle"></span></p>
                <p><strong>Start:</strong> <span id="calendarEventStart"></span></p>
                <p><strong>End:</strong> <span id="calendarEventEnd"></span></p>
                <p><strong>Type:</strong> <span id="calendarEventType"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="deleteCalendarEventBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Task Details -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> <span id="taskTitle"></span></p>
                <p><strong>Description:</strong> <span id="taskDescription"></span></p>
                <p><strong>Start:</strong> <span id="taskStart"></span></p>
                <p><strong>End:</strong> <span id="taskEnd"></span></p>
                <p><strong>Sprint:</strong> <span id="taskSprint"></span></p>
                <p><strong>Project:</strong> <span id="taskProject"></span></p>
                <p><strong>Type:</strong> <span id="taskType"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="goToTaskBtn">Go to Task</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('page-script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-o9DDUiYHCL4y9/bInkrWw/zrlVsq+v2u8Iu3BI5eqj6O3XftzweLwJ2pPwznn0g+DLFm9kRIW21cmXhHJjV/JA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css" integrity="sha512-WrA/v9myhSu4DyvEqeVpFbgsA8kC5Ql+8tUwm0XNK1e+4EZ1iYtthRk1W2aAiv3ldNKKy5EyCjPqy5EwR4IjDw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<style>
    /* FullCalendar */
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .fc-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: #F8FAF8;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 15px;
    }

    .fc-toolbar h2 {
        font-size: 1.8rem;
        margin-bottom: 0;
        color: #574956;
    }

    .fc-button {
        background-color: #3f58b0;
        border-color: #3f58b0;
        color: #fff;
        margin: 0 5px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        cursor: pointer;
    }

    .fc-button:hover {
        background-color: #2c3e6b;
        border-color: #2c3e6b;
    }

    .fc-center h2 {
        font-size: 1.5rem;
        margin: 0;
    }

    .fc-left,
    .fc-right {
        display: flex;
        align-items: center;
    }

    .fc-left .fc-button-group,
    .fc-right .fc-button-group {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }

    .fc-left .fc-button,
    .fc-right .fc-button {
        padding: 8px 12px;
    }

    .fc-prev-button .fc-icon:before,
    .fc-next-button .fc-icon:before {
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 1rem;
    }

    .fc-prev-button .fc-icon:before {
        content: '\1F81C';
    }

    .fc-next-button .fc-icon:after {
        content: '\2794';
    }

    .fc-event {
        margin-bottom: 0;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.9rem;
        line-height: 1.2;
        cursor: pointer;
        background-color: #0127fd;
    }

    /* Optional: Hover effect for events */
    .fc-event:hover {
        background-color: #0056b3;
    }

     /* Green color for Task events */
     .event-task {
        background-color: #28a745 !important;
        color: #fff; /* Text color for Task events */
    }

    /* Red color for past events */
    .event-past {
        background-color: #ff0000 !important;
        color: #fff; /* Text color for past events */
    }
</style>

<script>
    $(document).ready(function() {
        var booking = {!! json_encode($events) !!};

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: booking,
            editable: true,
            eventDrop: function(event) {
                var id = event.id;
                var start_date = event.start.format('YYYY-MM-DD HH:mm:ss');
                var end_date = event.end ? event.end.format('YYYY-MM-DD HH:mm:ss') : null;

                $.ajax({
                    url: "{{ route('calendar.update', '') }}/" + id,
                    type: "PATCH",
                    dataType: 'json',
                    data: {
                        start_date: start_date,
                        end_date: end_date,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        swal("Success", "Event updated successfully!", "success");
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        swal("Error", "There was an error updating the event.", "error");
                    },
                });
            },
            eventClick: function(event) {
                if (event.type === 'Task') {
                    $('#taskModal').modal('show');
                    $('#taskTitle').text(event.title);
                    $('#taskDescription').text(event.description); // Assuming 'description' is available in your event object
                    $('#taskStart').text(event.start.format('MMMM Do YYYY, h:mm a'));
                    $('#taskEnd').text(event.end ? event.end.format('MMMM Do YYYY, h:mm a') : 'No End Date');
                    $('#taskSprint').text(event.sprint); // Assuming 'sprint' is available in your event object
                    $('#taskProject').text(event.project); // Assuming 'project' is available in your event object
                    $('#taskType').text(event.type);
                    $('#goToTaskBtn').off().click(function() {
                        window.location.href = "/task/" + event.id + "/edit"; // Adjust the route as per your application
                    });
                } else {
                    $('#calendarEventModal').modal('show');
                    $('#calendarEventTitle').text(event.title);
                    $('#calendarEventStart').text(event.start.format('MMMM Do YYYY, h:mm a'));
                    $('#calendarEventEnd').text(event.end ? event.end.format('MMMM Do YYYY, h:mm a') : 'No End Date');
                    $('#calendarEventType').text(event.type);
                    $('#deleteCalendarEventBtn').off().click(function() {
                        $.ajax({
                            url: "{{ route('calendar.destroy', '') }}/" + event.id,
                            type: "DELETE",
                            dataType: 'json',
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                $('#calendarEventModal').modal('hide'); // Close modal after successful delete
                                swal("Success", "Event deleted successfully!", "success");
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                                swal("Error", "There was an error deleting the event.", "error");
                            },
                        });
                    });
                }
            },
            selectAllow: function(event) {
                return event.start.isSame(event.end, 'day');
            },
            eventRender: function(event, element) {
                var iconClass = 'fa fa-calendar';
                element.find('.fc-content').prepend('<i class="' + iconClass + '"></i>');

                // Check if event type is 'Task' and apply green background
                if (event.type === 'Task') {
                    element.addClass('event-task');
                }

                // Check if event end date is before today
                if (event.end < moment()) {
                    element.addClass('event-past');
                }
            },
            weekMode: 'liquid', // Ensure the calendar shows only the current month's weeks
        });
    });
</script>


@endsection
