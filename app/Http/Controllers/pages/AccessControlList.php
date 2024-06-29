<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Attachment;
use App\TeamMapping;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Team;
use App\Permission;
use App\Project;
use App\Sprint;
use App\UserStory;
use App\Forum;
use App\SecurityFeature;


class AccessControlList extends Controller
{

  public function index()
    {

        // Get the authenticated user
        $user = auth()->user();

        // Fetch sprints, user stories, forums, and security features created by the user
        $sprints = $user->sprints;
        $userStories = $user->userStories;
        $forums = $user->forums;
        $securityFeatures = $user->securityFeatures;


        if ($user->isAdmin()) {
            // If the user is an admin, fetch all projects
            $projects = Project::all();
            $teams = TeamMapping::all();
        } else {
        // Get the teams associated with the user
        $userTeams = $user->teamMappings()->pluck('team_name');

        // Fetch projects associated with the user's teams
        $projects = Project::whereIn('team_name', $userTeams)->get();


        // Fetch projects associated with the user's teams
        $teams = TeamMapping::whereIn('team_name', $userTeams)->get();
        }



        // sprints != different, user_stories == sprint_id, forums != different, securityFeatures != different.

        $users = User::all();
        // $teams = TeamMapping::all(); Fetch all teams
        $roles = Role::all(); // Fetch all roles
        $permissions = Permission::all(); // Fetch all permissions
        // $sprints = Sprint::all(); // Fetch all sprints
        $securityfeatures = SecurityFeature::all(); // Fetch all permissions
        $forums = Forum::all(); // Fetch all permissions
        // $userstories = UserStory::all(); // Fetch all permissions


        return view('content.pages.access-control-list', compact(
            'users', 'teams', 'roles', 'permissions', 'projects', 'sprints', 'userStories', 'forums', 'securityFeatures'
        ));

    }


    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->input('user_id'));
        $roleId = $request->input('role_id');

        if (!$user->roles->contains($roleId)) {
            $user->roles()->attach($roleId);
        }

        return redirect()->back()->with('success', 'Role assigned successfully!');
    }

    public function assignPermission(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->input('role_id'));
        $permissionId = $request->input('permission_id');

        if (!$role->permissions->contains($permissionId)) {
            $role->permissions()->attach($permissionId);
        }

        return redirect()->back()->with('success', 'Permission assigned successfully!');
    }


}

