<?php

namespace App\Http\Controllers;

use App\Sprint;
use Illuminate\Http\Request;
use App\Status;
use App\Task;
use App\Project;
use App\Http\Controllers\Auth;
use App\User;
use App\UserStory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KanbanController extends Controller
{
    public function kanbanIndex($proj_id, $sprint_id)
    {
        $sprint = Sprint::where('sprint_id', $sprint_id)->first();
        $project = Project::where('id', $proj_id)->first();
        $statuses = Status::where('project_id', $proj_id)->get();
        $tasks = Task::where("proj_id", $proj_id)->where("sprint_id", $sprint_id)->get();

        // Group tasks by status id
        $tasksByStatus = [];
        foreach ($tasks as $task) {
            $tasksByStatus[$task->status_id][] = $task;
        }

        return view('kanban.index', ['statuses' => $statuses, 'tasksByStatus' => $tasksByStatus, 'sprint' => $sprint, 'project' => $project]);
    }

    public function createStatus(Request $request)
    {
        // validate the request
        // $validation = $request->validate([
        //     'statusName' => 'required|unique:statuses,title',
        //     'sprintID' => 'required|exists:sprints,id',
        // ], [
        //     'statusName.required' => '*The Status Name is required',
        //     'statusName.unique' => '*There is already an existing Status with the same name',
        //     'sprintID.required' => '*The Sprint ID is required',
        //     'sprintID.exists' => '*The specified Sprint ID does not exist',
        // ]);

        // Extract data from the request
        $newLaneName = $request->input('statusName');
        $sprintID = $request->input('sprintID');
        $projectID = $request->input('project_id');

        // assign the request parameters to a new Status 
        $statuses = new Status();
        $statuses->title = $newLaneName;

        // Takes the title of status and changes it to lowercase and - when there is whitespace
        $slug = Str::slug($newLaneName, "-");
        $statuses->slug = strtolower($slug);

        // gets the highest order in the status with the same project and adds 1 order higher to the current status
        $projectID = $request->project_id;
        $highestOrder = DB::table('statuses')
            ->select(DB::raw('MAX(`order`) AS `highest_order`'))
            ->where('project_id', $projectID)
            ->first();

        $statuses->order = $highestOrder ? $highestOrder->highest_order + 1 : 1;
        $statuses->project_id = $request->project_id;
        $statuses->save();

        // redirect to the appropriate page
        // return back();
        return response()->json(['message' => 'Status created successfully', 'reload' => true]);
    }

    // Update the lane name
    public function updateStatus(Request $request)
    {
        $statusId = $request->input('statusId');
        $newName = $request->input('newName');

        try {
            $status = Status::findOrFail($statusId);
            $status->title = $newName;
            $status->slug = $newName;
            $status->save();

            return response()->json(['message' => 'Lane name updated successfully', 'reload' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating lane name'], 500);
        }
    }

    // Update task positions
    public function updateTaskStatus(Request $request)
    {
        $positions = $request->input('positions');

        try {
            foreach ($positions as $position) {
                $task = Task::find($position['taskId']);
                $task->status_id = $position['statusId'];
                $task->order = $position['position'];
                $task->save();
            }

            return response()->json(['message' => 'Task positions saved successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error saving task positions'], 500);
    }
    }

    // Delete a lane
    public function deleteStatus(Request $request)
    {
        $laneId = $request->input('laneId');

        try {
            // Find the order of the lane to be deleted
            $laneOrder = Status::where('id', $laneId)->value('order');

            // Find and delete the tasks associated with the lane using the Task model
            Task::where('status_id', $laneId)->delete();

            // Delete the lane
            Status::destroy($laneId);

            return response()->json(['success' => true, 'message' => 'Lane and associated tasks deleted successfully', 'reload' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error deleting lane and associated tasks'], 500);
        }
    }

    public function createTask(Request $request)
    {
        $sprintId = $request->input('sprintId');
        $statusId = $request->input('statusId');
        $sprint = Sprint::where('sprint_id', $sprintId)->first();
        $sprintProjName = $sprint->proj_name;
        $sprintProj = Project::where('proj_name', $sprintProjName)->first();
        $sprintProjId = $sprintProj->id;

        $userStories = UserStory::where('sprint_id', $sprintId)->get();
        $userList = User::all();

        return view('kanban.addTask', [
            'userStories' => $userStories,
            'userList' => $userList,
            'sprint_id' => $sprintId,
            'status_id' => $statusId,
            'sprintProjId' => $sprintProjId,
            'sprint' => $sprint
        ]);    
    }

    public function storeTask(Request $request)
    {
        $task = new Task();
        $tempUserStoryObj = UserStory::where('user_story', $request->userstory)->first();
        $task->userstory_id = $tempUserStoryObj->u_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_name = $request->user_name;
        $task->status_id = $request->status_id;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->proj_id = $request->sprintProjId;
        $task->sprint_id = $request->sprint_id;
        
        // Save the task to the database
        $task->save();

        // Redirect to kanban board
        $sprint = Sprint::where('sprint_id', $request->sprint_id)->first();
        $project = Project::where('id', $request->sprintProjId)->first();
        $statuses = Status::where('project_id', $request->sprintProjId)->get();
        $tasks = Task::where("proj_id", $request->sprintProjId)->where("sprint_id", $request->sprint_id)->get();

        // Group tasks by status id
        $tasksByStatus = [];
        foreach ($tasks as $task) {
            $tasksByStatus[$task->status_id][] = $task;
        }

        return redirect()->route('sprint.kanbanPage', ['proj_id' => $request->sprintProjId, 'sprint_id' => $request->sprint_id]);
    }

    // Delete a task
    public function deleteTask(Request $request)
    {
        $taskId = $request->input('taskId');

        try {
            // Find and delete the task
            Task::destroy($taskId);

            return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error deleting task'], 500);
        }
    }

    // Update a task
    public function updateTaskPage($taskId)
    {
        $task = Task::findOrFail($taskId);
        $userList = User::all();
        $status_id = $task->status_id;
        $sprint_id = $task->sprint_id;
        $sprintProjId = $task->proj_id;  // Add this line
        $userStories = UserStory::where('sprint_id', $task->sprint_id)->get();
        $sprint = Sprint::where('sprint_id', $sprint_id)->first();

        return view('kanban.updateTask', [
            'task' => $task,
            'userStories' => $userStories,
            'userList' => $userList,
            'status_id' => $status_id,
            'sprint_id' => $sprint_id,
            'sprintProjId' => $sprintProjId,  
            'sprint' => $sprint
        ]);
    }

    public function updateTask(Request $request, $taskId)
{
    $task = Task::findOrFail($taskId);

    // Validate the request
    $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'order' => 'required|numeric',
        'user_name' => 'required',
        'userstory' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    // Update task details
    $task->title = $request->input('title');
    $task->description = $request->input('description');
    $task->order = $request->input('order');
    $task->user_name = $request->input('user_name');
    $task->userstory_id = UserStory::where('user_story', $request->input('userstory'))->value('u_id');
    $task->start_date = $request->input('start_date');
    $task->end_date = $request->input('end_date');

    // Save the updated task to the database
    $task->save();

    // Redirect to kanban board or any other desired page
    return redirect()->route('sprint.kanbanPage', [
        'proj_id' => $task->proj_id,
        'sprint_id' => $task->sprint_id,
    ])->with('success', 'Task updated successfully');
}

}