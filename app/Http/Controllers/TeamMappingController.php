<?php

namespace App\Http\Controllers;

use App\UserAccess;
use App\Team;
use App\User;
use App\Role;
use App\Sprint;
use App\TeamMapping;
use App\Project;
use App\UserStory;
use App\Forum;
use App\SecurityFeature;
use App\Http\Controllers\Auth;

use Illuminate\Http\Request;


class TeamMappingController extends Controller
{
    public function index($team_name)
    {
        $user = \Auth::user();

        $team = new Team();
        $team = Team::where('team_name', $team_name)->first();
        $title = $team->team_name;
        $teammapping = new TeamMapping();
        $teammapping = TeamMapping::where('team_name', '=', "$team_name")->get();
        return view('teammapping.index',['teammappings'=>$teammapping])
            ->with('teams', $team)
            ->with('title', 'Team ' . $title);

    }

    public function create(Request $request)
    {
        $user = new User();
        $teammapping = new TeamMapping();
        $role = new Role();

        $teammapping = TeamMapping::where('team_name', '=', $request->team_name)->get();
        $user = User::whereNotIn('username', $teammapping->pluck('username'))->get();

        $role = $role->all();

        $teams = $request->teams;
        $team_name = $request->team_name;
        $title = 'Add Team Member to ' . $team_name;
        return view('teammapping.create')
            ->with('roles', $role)
            ->with('users', $user)
            ->with('team_name', $team_name)
            ->with('title', $title);

    }

    public function store(Request $request)
    {
        $validation = $request->validate([

            'username' => 'required',
            'role' => 'required',
        ],
        [
            'username.required' => '*The User is required',
            'role.required' => '*The Role Name is required',
        ]);

        $teammapping = new TeamMapping();

        //for team mapping table: save username, rolename and team name
        $teammapping->username = $request->username;
        $teammapping->role_name = $request->role;
        $teammapping->team_name = $request->team_name;
        $teammapping->save();

        $team = new Team();
        $team = Team::where('team_name', $request->team_name)->first();
        $teammapping = TeamMapping::where('team_name', '=', "$request->team_name")->get();

        return view('teammapping.index',['teammappings'=>$teammapping])
            ->with('teams', $team)
            ->with('success', 'Team member has successfully been added to team!')
            ->with('title', 'Team ' . $team->team_name);
;

    }

    public function show(Teammapping $teammapping)
    {
        $teammapping = new TeamMapping();
        return view('teammapping.show')->with ('teammappings',$teammapping->all());
    }

    public function edit(Teammapping $teammapping)
    {
        return view('teammappings.edit')->with('teammappings', Teammapping::all())->with('teammapping', $teammapping);
    }

    public function update(Request $request, Team $team)

    {
        //$team->user_name = $request->user_name;
        //$team->role = $request->role;
        $teammapping->username = $request->username;
        $teammapping->role_name = $request->role_name;
        $teammapping->save();

        return redirect()->route('teammapping.index', $teammapping);
    }

    public function destroy(Teammapping $teammapping)
    {
        $teammapping->delete();
        return redirect()->route('teammapping.index', $teammapping->team_name)
            ->with('success', 'Team member has been removed successfully');
    }

    public function search(Request $request)
    {
       // $user = new User;
        //$role = new Role;
       // $search = $request->get('search');
       // $teammapping = \App\User::query()->where('role', "%{$search}%");
         return response()->json(['success'=>'Got Simple Ajax Request.']);
       // return view('teammapping.create')->with('roles', $role->get(), 'username', $user->get());
    }

    public function saveAccessControl(Request $request)
    {
        try {
            $accessData = json_decode($request->input('accessData'), true);
            \Log::info('Access Data: ' . print_r($accessData, true));

            foreach ($accessData as $data) {
                \Log::info('Processing data: ' . print_r($data, true));

                // Set default values for access levels
                $data = array_merge([
                    'attachments' => 1,
                    'projects' => 1,
                    'sprints' => 1,
                    'user_stories' => 1,
                    'forums' => 1,
                    'security_features' => 1,
                ], $data);

                // Process project and attachments data
                if (isset($data['username']) && isset($data['proj_name'])) {
                    $user = User::where('username', $data['username'])->firstOrFail();
                    $project = Project::where('proj_name', $data['proj_name'])->firstOrFail();

                    \Log::info("Syncing project access for user {$user->id} and project {$project->id}");

                    // Sync project access
                    $user->projects()->syncWithoutDetaching([
                        $project->id => [
                            'project_access' => $data['projects'],
                            'attachment_access' => $data['attachments'],
                            'sprint_access' => $data['sprints'], // Ensure sprint_access is synced here
                            'userstory_access' => $data['user_stories'], // Ensure userstory_access is synced here
                            'forum_access' => $data['forums'], // Ensure forum_access is synced here
                            'secfeature_access' => $data['security_features'], // Ensure secfeature_access is synced here
                        ]
                    ]);

                    // If sprint data is provided, sync sprint access
                    if (isset($data['sprint_name'])) {
                        $sprint = Sprint::where('sprint_name', $data['sprint_name'])->firstOrFail();
                        $project->sprints()->syncWithoutDetaching([$sprint->id]);
                    }
                }

                // Process sprints data
                if (isset($data['username']) && isset($data['sprint_name'])) {
                    $user = User::where('username', $data['username'])->firstOrFail();
                    $sprint = Sprint::where('sprint_name', $data['sprint_name'])->firstOrFail();

                    \Log::info("Syncing sprint access for user {$user->id} and sprint {$sprint->id}");

                    // Sync sprint access
                    $user->sprintsAccess()->syncWithoutDetaching([
                        $sprint->id => [
                            'sprint_access' => $data['sprints'],
                        ]
                    ]);
                }

                // Process user stories data
                if (isset($data['username']) && isset($data['user_story'])) {
                    $user = User::where('username', $data['username'])->firstOrFail();
                    $userStory = UserStory::where('user_story', $data['user_story'])->firstOrFail();

                    \Log::info("Syncing user story access for user {$user->id} and user story {$userStory->id}");

                    // Sync user story access
                    $user->userStoriesAccess()->syncWithoutDetaching([
                        $userStory->id => [
                            'userstory_access' => $data['user_stories'],
                        ]
                    ]);
                }

                // Process forums data
                if (isset($data['user_id']) && isset($data['title'])) {
                    $user = User::where('user_id', $data['user_id'])->firstOrFail();
                    $forum = Forum::where('title', $data['title'])->firstOrFail();

                    \Log::info("Syncing forum access for user {$user->id} and forum {$forum->id}");

                    $user->forumsAccess()->syncWithoutDetaching([
                        $forum->id => [
                            'forum_access' => $data['forums'],
                        ]
                    ]);
                }

                // Process security features data
                if (isset($data['username']) && isset($data['secfeature_name'])) {
                    $user = User::where('username', $data['username'])->firstOrFail();
                    $securityFeature = SecurityFeature::where('secfeature_name', $data['secfeature_name'])->firstOrFail();

                    \Log::info("Syncing security feature access for user {$user->id} and security feature {$securityFeature->id}");

                    $user->securityFeaturesAccess()->syncWithoutDetaching([
                        $securityFeature->id => [
                            'secfeature_access' => $data['security_features'],
                        ]
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error saving access control: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }



    public function getTeamMembers1(Request $request)
    {
        \Log::info('Received request: ' . json_encode($request->all()));  // Log entire request data

        try {
            $username = $request->username;


            // Retrieve team names associated with the user's username
            $teamNames = TeamMapping::where('username', $username)->pluck('team_name');

            // Retrieve team members associated with the same teams
            $teamMembers = TeamMapping::whereIn('team_name', $teamNames)->get(['username', 'team_name', 'role_name']);

            $projectTeams = TeamMapping::where('username', $username)
            ->join('teams', 'teammappings.team_name', '=', 'teams.team_name')
            ->pluck('teams.team_name')
            ->toArray();

            // Retrieve team name associated with the user's username
            // $teamMembers1 = TeamMapping::where('username', $username)
            //   ->get(['username', 'team_name', 'role_name']);

            // Retrieve projects associated with the user's team
            $projects = Project::whereIn('projects.team_name', $projectTeams)
                ->join('teams', 'projects.team_name', '=', 'teams.team_name')
                ->join('teammappings', 'teammappings.team_name', '=', 'teams.team_name')
                ->where('teammappings.username', $username)
                ->select('teammappings.username', 'teams.team_name', 'projects.proj_name', 'projects.proj_desc')
                ->get();

            // Retrieve additional data for all team members
            $usernames = $teamMembers->pluck('username')->toArray();

            $sprints = Sprint::whereIn('users_name', $usernames)->get();
            \Log::info('Sprints data: ' . json_encode($sprints));

            $userStories = UserStory::where(function ($query) use ($usernames) {
                foreach ($usernames as $username) {
                    $query->orWhereJsonContains('user_names', $username);
                }
            })->get();
            \Log::info('User Stories data: ' . json_encode($userStories));

            // Fetch forums
            $userIds = User::whereIn('username', $usernames)->pluck('id')->toArray();
            \Log::info('User IDs for Forums: ' . json_encode($userIds));
            $forums = Forum::whereIn('user_id', $userIds)->get();
            \Log::info('Forums data: ' . json_encode($forums));


            // Fetch security features created by users of the team
            // $securityFeatures = SecurityFeature::whereHas('userStories.users', function ($query) use ($usernames) {
            // $query->whereIn('username', $usernames);
            // })->get();
            // \Log::info('Security Features data: ' . json_encode($securityFeatures));

        return response()->json([
            'teamMembers1' => $projects,
            'sprints' => $sprints,
            'userStories' => $userStories,
            'forums' => $forums,
            // 'securityFeatures' => $securityFeatures
        ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching team members: '.$e->getMessage());
            return response()->json(['error' => 'Failed to retrieve team members'], 500);
        }
    }



    public function getTeamMembers(Request $request)
    {
        \Log::info('Received request: ' . json_encode($request->all()));  // Log entire request data


        try {

            // Get the logged-in user's ID
            $user = \Auth::user();
            $username = $user->username;  // Get username

            if ($user->isAdmin()) {
                // Retrieve all team members
                $teamMembers = TeamMapping::all(['team_name']);

                // Extract team names from the collection
                $teamNames = $teamMembers->pluck('team_name')->toArray();

                // Fetch all projects
                $projects = Project::whereIn('team_name', $teamNames)
                    ->select('team_name', 'proj_name', 'proj_desc')
                    ->get();

                \Log::info('Projects data: ' . json_encode($projects));

                // Combine team members with their respective projects
                $mergedData = $teamMembers->map(function ($teamMember) use ($projects) {
                    $project = $projects->firstWhere('team_name', $teamMember->team_name);
                    return [
                        'team_name' => $teamMember->team_name,
                        'proj_name' => $project ? $project->proj_name : '',
                        'proj_desc' => $project ? $project->proj_desc : '',
                    ];
                });

                \Log::info('Merged data: ' . json_encode($mergedData));

                return response()->json($projects);
            }


            // Find the teams the user is part of
            $userTeams = TeamMapping::where('username', $username)
            ->join('teams', 'teammappings.team_name', '=', 'teams.team_name')
            ->pluck('teams.team_name')
            ->toArray();

            \Log::info('User teams: ' . json_encode($userTeams));  // Log user teams for debugging

            $teamMembers = Project::whereIn('projects.team_name', $userTeams)
            ->join('teams', 'projects.team_name', '=', 'teams.team_name')
            ->join('teammappings', 'teammappings.team_name', '=', 'teams.team_name')
            ->where('teammappings.username', $username)
            ->select('teammappings.username', 'teams.team_name', 'projects.proj_name', 'projects.proj_desc')
            ->get();

            \Log::info('Query executed successfully: '.json_encode($teamMembers));

            return response()->json($teamMembers);

        } catch (\Exception $e) {
            \Log::error('Error fetching team members: '.$e->getMessage());
            return response()->json(['error' => 'Failed to retrieve team members projects'], 500);
        }
    }
}
