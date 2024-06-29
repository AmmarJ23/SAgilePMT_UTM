<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TeamMapping;

class CheckProjectAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $projectId = $request->route('id'); // assuming the project ID is passed as a route parameter

        // Fetch the user's access rights for the project
        $access = TeamMapping::where('username', $user->username)
            ->where('projects', 1) // check if the user has access to projects
            ->exists();

        if (!$access) {
            return redirect()->route('home')->with('error', 'You do not have access to this project.');
        }

        return $next($request);
    }
}
