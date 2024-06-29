<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TeamMapping;
use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Team;
use App\Permission;


class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $teams = TeamMapping::all(); // Fetch all teams
        $roles = Role::all(); // Fetch all roles
        $permissions = Permission::all(); // Fetch all permissions




        return view('layouts.app2', compact('users', 'teams', 'roles', 'permissions'));
    }
}
