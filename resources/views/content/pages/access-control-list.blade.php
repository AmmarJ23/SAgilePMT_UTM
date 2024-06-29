@extends('layouts/contentNavbarLayout')

@section('title', 'Access Control List')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>

@endsection


@section('content')
@can('isAdmin')

<div class="container">
    <h1>Access Control List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

        </div>
    </div>


    <div class="row pt-2 mt-3">
        <div class="col-md-12">
          <div class="card">
            <!-- Modal for Assigning Roles -->
            <h5 class="card-header">Users and Teams in Project Management</h5>
            <div class="card-body">
              <span>This section will modify users engagement in teams, whether to add users in the team or remove them, applicable to Admin and Project Managers.<a href="javascript:void(0);" class="notificationRequest">Request Permission</a></span>
                <!-- Dropdown for selecting a team -->
                <form id="teamSelectForm">
                    @csrf
                    <div class="form-group">
                        <label for="teamSelectAdmin">Select a project</label>
                        <select id="teamSelectAdmin" name="id" class="form-control">
                            <option value="">Select a project</option>
                            @foreach($projects as $project)


                                    <option value="{{ $project->id }}">{{ $project->team_name }}: {{ $project->proj_name }}</option>


                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
              <table id="teamMembersTable" class="table">

                <thead class="table-light">
                  <tr>
                    <th class="text-nowrap fw-medium text-center">Team Name</th>

                    <th class="text-nowrap fw-medium text-center">Project Name</th>
                    <th class="text-nowrap fw-medium text-center">Project Description</th>
                    <th class="text-nowrap fw-medium text-center">Actions</th>
                  </tr>
                </thead>

                <tbody id="teamMembersAdmin">


                </tbody>

              </table>
            </div>



          </div>

          <div class="row pt-2 mt-3">
            <div class="col-md-12">
              <div class="card">

                <h5 class="card-header">Permission to Access in each of the section</h5>
                <div class="card-body">
                  <span>The user permissions will be modified of READ, WRITE AND DELETE content in the system. Please be wary when changing the permissions. <a href="javascript:void(0);" class="notificationRequest">Request Permission</a></span>
                  <div class="error"></div>
                                  <!-- Dropdown for selecting a team -->
                <form id="teamSelectForm">
                    @csrf
                    <div class="form-group">

                        <label for="teamSelect1_2" class="mt-3">Select Team:</label>
                        <select id="teamSelect1_2" name="username" class="form-control">
                            <option value="">Select a team member</option>
                            @foreach($teams as $team)
                            <option value="{{ $team->username }}">{{ $team->team_name }}: {{ $team->username}}</option>
                            @endforeach
                        </select>

                    </div>
                </form>
                </div>
                <div class="table-responsive">
                  <table id="teamMembersTable" class="table">
                    <thead class="table-light">
                      <tr>
                        <th class="text-nowrap fw-medium text-center">Name</th>
                        <th class="text-nowrap fw-medium text-center">Attachments</th>
                        <th class="text-nowrap fw-medium text-center">Projects</th>
                        <!--checkbox here-->
                        <th class="text-nowrap fw-medium text-center">Access/No Access on projects</th>
                      </tr>
                    </thead>
                    <tbody id="teamMembers1">

                    </tbody>
                  </table>
                </div>

                {{--
                <form id="teamSelectForm1">
                    @csrf
                    <div class="form-group">

                        <label for="teamSelect1_1" class="mt-3">Select Team:</label>
                        <select id="teamSelect1_1" name="username" class="form-control">
                            <option value="">Select a team member</option>
                            @foreach($teams as $team)
                            <option value="{{ $team->username }}">{{ $team->team_name }}: {{ $team->username}}</option>
                            @endforeach
                        </select>

                    </div>
                </form>
                --}}
                <div class="table-responsive">
                  <table id="teamMembersTable1" class="table mt-3">
                    <thead class="table-light">
                      <tr>

                        <th class="text-nowrap fw-medium text-center">Name</th>
                        <th class="text-nowrap fw-medium text-center">Sprints</th>
                        <th class="text-nowrap fw-medium text-center">Access/No Access</th>
                        <th class="text-nowrap fw-medium text-center">Start Sprint</th>
                        <!--checkbox here-->
                        <th class="text-nowrap fw-medium text-center">End Sprint</th>
                      </tr>

                    </thead>
                    <tbody id="teamMembers2">

                    </tbody>
                  </table>
                </div>

                {{--
                <form id="teamSelectForm2">
                    @csrf
                    <div class="form-group">

                        <label for="teamSelect1_2" class="mt-3">Select Team:</label>
                        <select id="teamSelect1_2" name="username" class="form-control">
                            <option value="">Select a team member</option>
                            @foreach($teams as $team)
                            <option value="{{ $team->username }}">{{ $team->team_name }}: {{ $team->username}}</option>
                            @endforeach
                        </select>

                    </div>
                </form>
                --}}

                <div class="table-responsive">
                  <table id="teamMembersTable" class="table mt-3">
                    <thead class="table-light">
                      <tr>

                        <th class="text-nowrap fw-medium text-center">Name</th>
                        <th class="text-nowrap fw-medium text-center">Means</th>
                        <th class="text-nowrap fw-medium text-center">User Stories</th>
                      </tr>

                    </thead>
                    <tbody id="teamMembers3">

                    </tbody>
                  </table>
                </div>

                {{--
                <div class="table-responsive">
                    <table id="teamMembersTable1" class="table mt-3">
                      <thead class="table-light">
                        <tr>

                          <th class="text-nowrap fw-medium text-center">Forum Title</th>
                          <th class="text-nowrap fw-medium text-center">Content</th>
                        </tr>

                      </thead>
                      <tbody id="teamMembers4">

                      </tbody>
                    </table>
                  </div>


                  <div class="table-responsive">
                    <table id="teamMembersTable1" class="table mt-3">
                      <thead class="table-light">
                        <tr>

                          <th class="text-nowrap fw-medium text-center">Security Feature Name</th>
                          <th class="text-nowrap fw-medium text-center">Security Feature Description</th>
                        </tr>

                      </thead>
                      <tbody id="teamMembers5">

                      </tbody>
                    </table>
                  </div>
                  --}}

                <div class="card-body">
                  <h6 class="mb-4">Are you sure about the modifications?</h6>
                  <form action="javascript:void(0);">
                    <div class="row">
                      <div class="col-sm-6">
                        <select id="sendNotification" class="form-select" name="sendNotification">
                          <option selected>Yes</option>
                          <option>No</option>
                        </select>
                      </div>
                      <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /Notifications -->

              </div>

        </div>
      </div>
</div>
@endcan

@can('isProjectManager')

<form id="accessControlForm" method="POST">
@csrf

    <div class="container">
        <h1>Access Control List</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

            </div>
        </div>


        <div class="row pt-2 mt-3">
            <div class="col-md-12">
            <div class="card">
                <!-- Modal for Assigning Roles -->
                <h5 class="card-header">Users and Teams in Project Management</h5>
                <div class="card-body">
                <span>This section will modify users engagement in teams, whether to add users in the team or remove them, applicable to Admin and Project Managers.<a href="javascript:void(0);" class="notificationRequest">Request Permission</a></span>
                    <!-- Dropdown for selecting a team -->
                    <form id="teamSelectForm">
                        @csrf
                        <div class="form-group">
                            <label for="teamSelect">Select a project</label>
                            <select id="teamSelect" name="id" class="form-control">
                                <option value="">Select a project</option>
                                @foreach($projects as $project)


                                        <option value="{{ $project->id }}">{{ $project->team_name }}: {{ $project->proj_name }}</option>


                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                <table id="teamMembersTable" class="table">

                    <thead class="table-light">
                    <tr>
                        <th class="text-nowrap fw-medium text-center">Team Name</th>
                        <th class="text-nowrap fw-medium text-center">Username</th>
                        <th class="text-nowrap fw-medium text-center">Project Name</th>
                        <th class="text-nowrap fw-medium text-center">Project Description</th>
                        <th class="text-nowrap fw-medium text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody id="teamMembers">


                    </tbody>

                </table>
                </div>



            </div>

            <div class="row pt-2 mt-3">
                <div class="col-md-12">
                <div class="card">

                    <h5 class="card-header">Permission to Access in each of the section</h5>
                    <div class="card-body">
                    <span>The user permissions will be modified of READ, WRITE AND DELETE content in the system. Please be wary when changing the permissions. <a href="javascript:void(0);" class="notificationRequest">Request Permission</a></span>
                    <div class="error"></div>
                                    <!-- Dropdown for selecting a team -->
                    <form id="teamSelectForm">
                        @csrf
                        <div class="form-group">

                            <label for="teamSelect1_2" class="mt-3">Select Team:</label>
                            <select id="teamSelect1_2" name="username" class="form-control">
                                <option value="">Select a team member</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->username }}">{{ $team->team_name }}: {{ $team->username}}</option>
                                @endforeach
                            </select>

                        </div>
                    </form>
                    </div>
                    <div class="table-responsive">
                    <table id="teamMembersTable" class="table">
                        <thead class="table-light">
                        <tr>

                            <th class="text-nowrap fw-medium text-center">Name</th>
                            <th class="text-nowrap fw-medium text-center">Attachments</th>
                            <th class="text-nowrap fw-medium text-center">Projects</th>
                            <!--checkbox here-->
                            <th class="text-nowrap fw-medium text-center">Access/No Access on projects</th>
                        </tr>
                        </thead>
                        <tbody id="teamMembers1">

                        </tbody>
                    </table>
                    </div>

                    {{--
                    <form id="teamSelectForm1">
                        @csrf
                        <div class="form-group">

                            <label for="teamSelect1_1" class="mt-3">Select Team:</label>
                            <select id="teamSelect1_1" name="username" class="form-control">
                                <option value="">Select a team member</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->username }}">{{ $team->team_name }}: {{ $team->username}}</option>
                                @endforeach
                            </select>

                        </div>
                    </form>
                    --}}
                    <div class="table-responsive">
                    <table id="teamMembersTable1" class="table mt-3">
                        <thead class="table-light">
                        <tr>

                            <th class="text-nowrap fw-medium text-center">Name</th>
                            <th class="text-nowrap fw-medium text-center">Sprints</th>
                            <th class="text-nowrap fw-medium text-center">Access/No Access</th>
                            <th class="text-nowrap fw-medium text-center">Start Sprint</th>
                            <!--checkbox here-->
                            <th class="text-nowrap fw-medium text-center">End Sprint</th>
                        </tr>

                        </thead>
                        <tbody id="teamMembers2">

                        </tbody>
                    </table>
                    </div>

                    {{--
                    <form id="teamSelectForm2">
                        @csrf
                        <div class="form-group">

                            <label for="teamSelect1_2" class="mt-3">Select Team:</label>
                            <select id="teamSelect1_2" name="username" class="form-control">
                                <option value="">Select a team member</option>
                                @foreach($teams as $team)
                                <option value="{{ $team->username }}">{{ $team->team_name }}: {{ $team->username}}</option>
                                @endforeach
                            </select>

                        </div>
                    </form>
                    --}}

                    <div class="table-responsive">
                    <table id="teamMembersTable" class="table mt-3">
                        <thead class="table-light">
                        <tr>

                            <th class="text-nowrap fw-medium text-center">Name</th>
                            <th class="text-nowrap fw-medium text-center">Means</th>
                            <th class="text-nowrap fw-medium text-center">User Stories</th>
                        </tr>

                        </thead>
                        <tbody id="teamMembers3">

                        </tbody>
                    </table>
                    </div>

                    {{--
                    <div class="table-responsive">
                        <table id="teamMembersTable1" class="table mt-3">
                        <thead class="table-light">
                            <tr>

                            <th class="text-nowrap fw-medium text-center">Forum Title</th>
                            <th class="text-nowrap fw-medium text-center">Content</th>
                            </tr>

                        </thead>
                        <tbody id="teamMembers4">

                        </tbody>
                        </table>
                    </div>


                    <div class="table-responsive">
                        <table id="teamMembersTable1" class="table mt-3">
                        <thead class="table-light">
                            <tr>

                            <th class="text-nowrap fw-medium text-center">Security Feature Name</th>
                            <th class="text-nowrap fw-medium text-center">Security Feature Description</th>
                            </tr>

                        </thead>
                        <tbody id="teamMembers5">

                        </tbody>
                        </table>
                    </div>
                    --}}


                    <div class="card-body">
                    <h6 class="mb-4">Are you sure about the modifications?</h6>
                    <form action="javascript:void(0);">
                        <div class="row">
                        <div class="col-sm-6">
                            <select id="sendNotification" class="form-select" name="sendNotification">
                            <option selected>Yes</option>
                            <option>No</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                        </div>
                    </form>
                    </div>
                    <!-- /Notifications -->

                </div>

            </div>
        </div>
    </div>
</form>

@endcan

@can('isUser')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Access Denied') }}</div>

                <div class="card-body">
                    <h1>403</h1>
                    <p>{{ __('You do not have permission to access this page.') }}</p>
                    @foreach($teams as $team)
                    @foreach($projects as $project)
                    @endforeach
                    @endforeach
                    <a href="{{ url('/home') }}" class="btn btn-primary">Go to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan



<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



{{--The script here applies both  on Project Managers and Admins--}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('teamSelect').addEventListener('change', function () {
            const teamId = this.value;
            const token = document.querySelector('input[name="_token"]').value;

            console.log('Team selected:', teamId);  // Debugging statement

            if (teamId) {
                fetch('{{ route("getTeamMembers") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ id: teamId })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);  // Debugging statement
                    const tbody = document.getElementById('teamMembers');
                    tbody.innerHTML = '';

                    data.forEach(member => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="text-nowrap text-heading text-center">${member.team_name}</td>
                            <td class="text-truncate align-center text-center">${member.username}</td>
                            <td class="text-truncate align-center text-center">${member.proj_name}</td>
                            <td class="text-truncate align-center text-center"><span>${member.proj_desc}</span></td>
                            <td class="text-center">

                                <div class="mt-3 mb-1">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                                </div>

                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error fetching team members:', error));
            } else {
                document.getElementById('teamMembers').innerHTML = '';
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('teamSelectAdmin').addEventListener('change', function () {
        const teamId = this.value;
        const token = document.querySelector('input[name="_token"]').value;

        console.log('Team selected:', teamId);  // Debugging statement

        if (teamId) {
            fetch('{{ route("getTeamMembers") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ id: teamId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);  // Debugging statement
                const tbody = document.getElementById('teamMembersAdmin');
                tbody.innerHTML = '';

                if (Array.isArray(data)) {
                    data.forEach(member => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="text-nowrap text-heading text-center">${member.team_name}</td>

                            <td class="text-truncate align-center text-center">${member.proj_name || ''}</td>
                            <td class="text-truncate align-center text-center"><span>${member.proj_desc || ''}</span></td>
                            <td class="text-center">

                                    <div class="mt-3 mb-1">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                                    </div>

                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    console.error('Data is not an array:', data);
                }
            })
            .catch(error => console.error('Error fetching team members:', error));
        } else {
            document.getElementById('teamMembersAdmin').innerHTML = '';
        }
    });
});


</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fetchUserData = (username) => {
            const token = document.querySelector('input[name="_token"]').value;

            if (username) {
                fetch('{{ route("getTeamMembers1") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ username: username })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);

                    if (data.teamMembers1 && Array.isArray(data.teamMembers1)) {
                        const teamMembers1Body = document.getElementById('teamMembers1');
                        teamMembers1Body.innerHTML = '';
                        data.teamMembers1.forEach(member => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="username text-truncate align-center text-center">${member.username}</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0 attachments">
                                        <input class="form-check-input attachments-checkbox" type="checkbox" checked />
                                    </div>
                                </td>
                                <td class="text-truncate align-center text-center proj-name">${member.proj_name}</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0 projects">
                                        <input class="form-check-input projects-checkbox" type="checkbox" checked />
                                    </div>
                                </td>
                            `;
                            teamMembers1Body.appendChild(tr);
                        });
                    }

                    if (data.sprints && Array.isArray(data.sprints)) {
                        const teamMembers2Body = document.getElementById('teamMembers2');
                        teamMembers2Body.innerHTML = '';
                        data.sprints.forEach(sprint => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="sprint-name text-truncate align-center text-center">${sprint.sprint_name}</td>
                                <td class="sprint-desc text-truncate align-center text-center">${sprint.sprint_desc}</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0 sprints">
                                        <input class="form-check-input sprints-checkbox" type="checkbox" checked />
                                    </div>
                                </td>
                                <td class="text-truncate align-center text-center">${sprint.start_sprint}</td>
                                <td class="text-truncate align-center text-center">${sprint.end_sprint}</td>
                            `;
                            teamMembers2Body.appendChild(tr);
                        });
                    }

                    if (data.userStories && Array.isArray(data.userStories)) {
                        const teamMembers3Body = document.getElementById('teamMembers3');
                        teamMembers3Body.innerHTML = '';
                        data.userStories.forEach(userStory => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="user-story text-truncate align-center text-center">${userStory.user_story}</td>
                                <td class="means text-truncate align-center text-center">${userStory.means}</td>
                                <td class="user-names text-truncate align-center text-center">${userStory.user_names}

                                    <div class="form-check mb-0 d-flex justify-content-center mb-0 userstories">
                                        <input class="form-check-input userstories-checkbox" type="checkbox" checked />
                                    </div>
                                </td>
                            `;
                            teamMembers3Body.appendChild(tr);
                        });
                    }

                    if (data.forums && Array.isArray(data.forums)) {
                        const teamMembers4Body = document.getElementById('teamMembers4');
                        teamMembers4Body.innerHTML = '';
                        data.forums.forEach(forum => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="forum-title text-truncate align-center text-center">${forum.title}</td>
                                <td class="forum-content text-truncate align-center text-center">${forum.content}</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0 forums">
                                        <input class="form-check-input forums-checkbox" type="checkbox" checked />
                                    </div>
                                </td>
                            `;
                            teamMembers4Body.appendChild(tr);
                        });
                    }

                    if (data.securityFeatures && Array.isArray(data.securityFeatures)) {
                        const teamMembers5Body = document.getElementById('teamMembers5');
                        teamMembers5Body.innerHTML = '';
                        data.securityFeatures.forEach(securityFeature => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="secfeature-name text-truncate align-center text-center">${securityFeature.secfeature_name}</td>
                                <td class="secfeature-desc text-truncate align-center text-center">${securityFeature.secfeature_desc}</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0 securityfeatures">
                                        <input class="form-check-input securityfeatures-checkbox" type="checkbox" checked />
                                    </div>
                                </td>
                            `;
                            teamMembers5Body.appendChild(tr);
                        });
                    }
                })
                .catch(error => console.error('Error fetching user data:', error));
            } else {
                document.getElementById('teamMembers1').querySelector('tbody').innerHTML = '';
                document.getElementById('teamMembers2').querySelector('tbody').innerHTML = '';
                document.getElementById('teamMembers3').querySelector('tbody').innerHTML = '';
                document.getElementById('teamMembers4').querySelector('tbody').innerHTML = '';
                document.getElementById('teamMembers5').querySelector('tbody').innerHTML = '';
            }
        };

        document.getElementById('teamSelect1_2').addEventListener('change', function () {
            fetchUserData(this.value);
        });

        // Handle save changes button
        document.querySelector('button[type="submit"]').addEventListener('click', function() {
            const token = document.querySelector('input[name="_token"]').value; // Ensure token is defined here

            const accessData = [];

            const collectRowData = (row, selectors) => {
                const data = {};
                selectors.forEach(selector => {
                    const element = row.querySelector(selector.selector);
                    if (element) {
                        // Check if the selector is supposed to be sent as an array
                        if (selector.type === 'array') {
                            // Convert the value to an array
                            data[selector.name] = [element.textContent.trim()];
                        } else {
                            data[selector.name] = selector.type === 'checkbox' ? (element.checked ? 1 : 0) : element.textContent.trim();
                        }
                    }
                });
                return data;
            };

            const rowSelectors = [
                {
                    tableId: '#teamMembers1',
                    selectors: [
                        { selector: '.username', name: 'username' },
                        { selector: '.proj-name', name: 'proj_name' },
                        { selector: '.attachments-checkbox', name: 'attachments', type: 'checkbox' },
                        { selector: '.projects-checkbox', name: 'projects', type: 'checkbox' },
                    ]
                },
                {
                    tableId: '#teamMembers2',
                    selectors: [
                        { selector: '.sprint-name', name: 'sprint_name' },
                        { selector: '.sprint-desc', name: 'sprint_desc' },
                        { selector: '.sprints-checkbox', name: 'sprint', type: 'checkbox' },
                    ]
                },
                {
                    tableId: '#teamMembers3',
                    selectors: [
                        { selector: '.user-story', name: 'user_story' },
                        { selector: '.means', name: 'means' },
                        { selector: '.user-names', name: 'user_names' },
                        { selector: '.userstories-checkbox', name: 'user_stories', type: 'checkbox' },
                    ]
                },
                {
                    tableId: '#teamMembers4',
                    selectors: [
                        { selector: '.forum-title', name: 'forum_title' },
                        { selector: '.forum-content', name: 'forum_content' },
                        { selector: '.forums-checkbox', name: 'forums', type: 'checkbox' },
                    ]
                },
                {
                    tableId: '#teamMembers5',
                    selectors: [
                        { selector: '.secfeature-name', name: 'secfeature_name' },
                        { selector: '.secfeature-desc', name: 'secfeature_desc' },
                        { selector: '.securityfeatures-checkbox', name: 'security_features', type: 'checkbox' },
                    ]
                }
            ];

            rowSelectors.forEach(rowSelector => {
                document.querySelectorAll(rowSelector.tableId + ' tr').forEach(row => {
                    const rowData = collectRowData(row, rowSelector.selectors);
                    console.log('Row Data:', rowData); // Log each row's data for debugging
                    accessData.push(rowData);
                });
            });

            console.log('Access Data:', accessData); // Log the access data for debugging

            fetch('{{ route("saveAccessControl") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ accessData: JSON.stringify(accessData) })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Changes saved successfully!');
                    } else {
                        alert('Failed to save changes: ' + data.message);
                    }
                })
                .catch(error => console.error('Error saving changes:', error));
        });
    });
</script>
@endsection


