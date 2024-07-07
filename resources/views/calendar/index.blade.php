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

@include('inc.navbar')

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
        content: '\f053';
    }

    .fc-next-button .fc-icon:after {
        content: '\f054';
    }

    .fc-event {
        margin-bottom: 5px;
        padding: 2px 5px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 0.8rem;
        line-height: 1.2;
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
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this event!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ route('calendar.destroy', '') }}/" + event.id,
                            type: "DELETE",
                            dataType: 'json',
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                swal("Success", "Event deleted successfully!", "success");
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                                swal("Error", "There was an error deleting the event.", "error");
                            },
                        });
                    } else {
                        swal("Your event is safe!");
                    }
                });
            },
            selectAllow: function(event) {
                return event.start.isSame(event.end, 'day');
            },
            eventRender: function(event, element) {
                var iconClass = 'fa fa-calendar';
                element.find('.fc-content').prepend('<i class="' + iconClass + '"></i>');
            }
        });
    });
</script>

@endsection
