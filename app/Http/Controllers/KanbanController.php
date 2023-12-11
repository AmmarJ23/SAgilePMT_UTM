<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\Task;

class KanbanController extends Controller
{
    public function kanbanIndex($proj_id, $sprint_id)
    {
        $statuses = Status::where('project_id', $proj_id)->get();
        $tasks = Task::where("proj_id", $proj_id)->where("sprint_id", $sprint_id)->get();

        // Group tasks by status id
        $tasksByStatus = [];
        foreach ($tasks as $task) {
            $tasksByStatus[$task->status_id][] = $task;
        }

        return view('kanban.index', ['statuses' => $statuses, 'tasksByStatus' => $tasksByStatus]);
    }

    
}
