<?php

namespace App\Http\Controllers;
use App\Sprint;
use App\Project;
use App\UserStory;
use App\Task;
use App\User;
use App\ProductFeature;
use App\Http\Controllers\Auth;
use DB;

use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function index()
    { 
        $project = new Project;
        if (\Auth::check())
        {
            $id = \Auth::user()->getId();
            
        }
        if($id)
        {
            $pro = \App\Project::where('user_id', '=', $id)->get();
            return view('profeature.index',['projects'=>$project, 'pros'=>$pro]);
        }
        
        $sprint = new Sprint;
        return view ('sprint.index', ['sprints'=>$sprint->all(), 'projects'=>$project->all()]);
    }

    public function create($proj_name)
    {
        //We want to send project to store project name and display 
        //the start and end project date at the create sprint page

        $project = Project::where('proj_name', $proj_name)->first();
        return view('sprint.create')
            ->with('title', 'Create Sprint for '. $project->proj_name)
            ->with('project', $project);
    }

    public function destroy(Sprint $sprint)
    {   
        $proj_name = $sprint->proj_name;
        $deleted_sprint = $sprint->sprint_name;
        $sprints = Sprint::where('proj_name', $proj_name)->get();
        $project = Project::where('proj_name', $proj_name)->first();

        // Get user stories related to the sprint
        $userstories = UserStory::where('sprint_id', $sprint->sprint_id)->get();

        foreach ($userstories as $userstory) {
            // Get tasks related to each user story
            $tasks = Task::where('userstory_id', $userstory->u_id)->get();
            
            // Delete tasks related to the user story
            $tasks->each->delete();
            
            // Delete the user story
            $userstory->delete();
        }

        // Delete the sprint
        $sprint->delete();

        return redirect()->route('profeature.index2', ['proj_name' => $proj_name])
            ->with('title', 'Sprints for ' . $proj_name)
            ->with('success', $deleted_sprint . ' has successfully been deleted!')
            ->with('sprints', $sprints)
            ->with('projects', $project);
    }
 
    
    public function store(Request $request)
    {
        //Get the current project
        $project = Project::where('proj_name', $request->proj_name)->first();

        // Get the current authenticated user's username
        $username = \Auth::user()->username;

        //we need to validate the request
        $validation = $request->validate([
            //validate for existing sprint_names
            'sprint_name' => 'required|unique:sprint,sprint_name,NULL,sprint_id,proj_name,'.$request->proj_name, 
            'sprint_desc' => 'required',

            //validate that start of sprint should be after or equal the project's start date
            'start_sprint' => 'required|date|after_or_equal:'.$project->start_date,

            //validate that end of sprint should be before or equal the project's end date
            'end_sprint' => 'required|date|before_or_equal:'.$project->end_date.'|after_or_equal:start_sprint'
        ], [
            'sprint_name.required' => '*The Sprint Name is required',
            'sprint_name.unique' => '*There is already an existing sprint in the project with the same name',
            'sprint_desc.required' => '*The Description is required',
            'start_sprint.required' => '*The Start Date is required',
            'start_sprint.after_or_equal' => '*The Start Date must be equal to or after the project start date',
            'end_sprint.required' => '*The End Date is required',
            'end_sprint.before_or_equal' => '*The End Date must be equal to or before the project end date',
            'end_sprint.after_or_equal' => '*The End Date must be equal to or after the Start Date'
        ]);

        //assign request values to new sprint 
        $sprint = new Sprint();
        $sprint->sprint_name = $request->sprint_name;
        $sprint->proj_name = $request->proj_name;
        $sprint->sprint_desc = $request->sprint_desc;
        $sprint->start_sprint = $request->start_sprint;
        $sprint->end_sprint = $request->end_sprint;

        // Assign the username to the sprint
        $sprint->users_name=$username;

        $sprint->save();

        $sprints = Sprint::where('proj_name', $request->proj_name)->get();

        //return title, current project and sprints related to the project
        return redirect()->route('profeature.index2', ['proj_name' => $request->proj_name])
            ->with('title', 'Sprints for ' . $request->proj_name)
            ->with('success', 'Sprint has successfully been created!')
            ->with('sprints', $sprints)
            ->with('projects', $project);

    }

    public function edit($sprint_id)
    {
        //Get the current sprint
        $sprint = Sprint::where('sprint_id', $sprint_id)->first();
        $project =Project::where('proj_name', $sprint->proj_name)->first();

        return view('sprint.edit')
            ->with('title', 'Edit '. $sprint->sprint_name . ' in '. $sprint->proj_name)
            ->with('project', $project)
            ->with('sprint', $sprint);
    }

    public function update(Request $request, Sprint $sprint)
    {
        //Only save desc, and dates because no need to update name and project name
        $sprint->sprint_desc = $request->sprint_desc;
        $sprint->start_sprint = $request->start_sprint;
        $sprint->end_sprint = $request->end_sprint; 
    
        //Get the current project
        $project = Project::where('proj_name', $sprint->proj_name)->first();

        $validation = $request->validate([
            'sprint_desc' => 'required',

            //validate that start of sprint should be after or equal the project's start date
            'start_sprint' => 'required|date|after_or_equal:'.$project->start_date,

            //validate that end of sprint should be before or equal the project's end date
            'end_sprint' => 'required|date|before_or_equal:'.$project->end_date.'|after_or_equal:start_sprint'
        ], [
            'sprint_desc.required' => '*The Description is required',
            'start_sprint.required' => '*The Start Date is required',
            'start_sprint.after_or_equal' => '*The Start Date must be equal to or after the project start date',
            'end_sprint.required' => '*The End Date is required',
            'end_sprint.before_or_equal' => '*The End Date must be equal to or before the project end date',
            'end_sprint.after_or_equal' => '*The End Date must be equal to or after the Start Date'
        ]);

        $sprint->save();
        $sprints = Sprint::where('proj_name', $sprint->proj_name)->get();

        //return title, current project and sprints related to the project
        return redirect()->route('profeature.index2', ['proj_name' => $sprint->proj_name])
            ->with('title', 'Sprints for ' . $sprint->proj_name)
            ->with('success', 'Sprint has successfully been updated!')
            ->with('sprints', $sprints)
            ->with('projects', $project);
    }
    

}

       
        