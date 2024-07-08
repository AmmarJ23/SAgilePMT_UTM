<?php

namespace App\Http\Controllers;

use App\Calendar; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Task;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();
    
        // Fetch tasks from the Task model where user_names JSON contains the authenticated user's username
        $tasks = Task::whereJsonContains('user_names', [$user->username])
                    ->get()
                    ->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'title' => $task->title,
                            'start' => $task->start_date,
                            'end' => $task->end_date,
                            'color' => '#808080',
                            'editable' => false,
                            'iconClass' => 'fas fa-tasks', // Default icon class for tasks
                            'type' => 'Task', // Type of event
                        ];
                    });
    
                    
                    // dd( $tasks);
        // Fetch events from the Calendar model
        $events = Calendar::all()->map(function ($event) {
            $color = null;
            $iconClass = null;
            $type = null;
            if ($event->title == 'Test') {
                $color = '#924ACE';
                $iconClass = 'fas fa-briefcase';
                $type = 'Calendar Event'; // Type of event
            } elseif ($event->title == 'Test 1') {
                $color = '#68B01A';
                $iconClass = 'fas fa-briefcase';
                $type = 'Calendar Event'; // Type of event
            }
    
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'color' => $color,
                'editable' => true,
                'iconClass' => $iconClass,
                'type' => $type,
            ];
        });
    
        // Merge tasks and events into a single array
        $data = $tasks->merge($events);
    
        return view('calendar.index', ['events' => $data]);
    }
    

    public function create()
    {
        return view('calendar.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $booking = Calendar::create([
        'title' => $request->title,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    // Flash success message to session
    session()->flash('success', 'Event created successfully!');

    return redirect()->route('calendar.index');
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = Calendar::find($id);
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to locate the event',
            ], 404);
        }

        $booking->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json('Event updated');
    }

    public function destroy($id)
    {
        $booking = Calendar::find($id);
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to locate the event',
            ], 404);
        }

        $booking->delete();

        return response()->json(['id' => $id]);
    }
}
