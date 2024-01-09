@extends('layouts.app2') 
@include('inc.style')
@include('inc.navbar')

@section('content')
    <!-- Your form and HTML content -->
    <div>
        @include('inc.title')
        <br>
        <form action="{{ route('teams.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>1. Fill in your team details:</h3>

            <!-- Team Name Input -->
            Team Name: <input type="text" name="team_name" style="margin-left:2.5em">
            <div class="error"><font color="red" size="2">{{ $errors->first('team_name') }}</font></div>
            <br><br>

            <!-- Button to Open Modal -->
            <button class="open-button" onclick="openForm(event)">Add Team Member</button>

            <!-- Div to Display Added Team Members -->
            <div id="teamMembers">
                <!-- Here, JavaScript will dynamically add the team members' emails -->
            </div>

            <!-- Submit Button -->
            <button type="submit" onclick="submitTeam(event)">Create Team</button>
        </form>

        <!-- Pop-up form for adding team member -->
        <div class="form-popup" id="addMemberPopup" style="display: none;">
            <form class="form-container" onsubmit="saveMember(event)">
                <h1>Add Team Member</h1>
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>
               <!-- Select dropdown for choosing role -->
<label for="role"><b>Role</b></label>
<select name="role" id="role">
    @foreach($roles as $role)
        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
    @endforeach
</select>

                <button type="button" class="btn" onclick="saveMember(event)">Save</button>
                <button type="button" class="btn cancel" onclick="closePopup()">Close</button>
            </form>
        </div>

        <!-- Table to display added team members -->
        <div id="teamMembersTable">
            <table id="membersTable">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Role</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>

    </div>

    <!-- Include necessary scripts -->
    <script>
        function openForm(event) {
            event.preventDefault();
            document.getElementById("addMemberPopup").style.display = "block";
        }

        function saveMember(event) {
    event.preventDefault();

    var email = document.getElementById('email').value;
    var role = document.getElementById('role').options[document.getElementById('role').selectedIndex].text;

    var tableBody = document.querySelector('#membersTable tbody');

    var newRow = tableBody.insertRow();

    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);

    cell1.innerHTML = email;
    cell2.innerHTML = role; // Display role

    sendEmail(email, role);

    document.getElementById('email').value = '';
    document.getElementById('role').value = 'role1';
}



        function sendEmail(email, role) {
            // Send an AJAX request to Laravel to handle the email sending
            axios.post('{{ route("send.invitation.email") }}', {
                email: email,
                role: role,
            })
            .then(function(response) {
                console.log('Email sent successfully');
            })
            .catch(function(error) {
                console.error('Error sending email:', error);
            });
        }

        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        function closePopup() {
            document.getElementById("addMemberPopup").style.display = "none";
        }

        function submitTeam(event) {
            // Add logic for submitting the team if needed
            window.location.href = "{{ route('team.index') }}";
        }

        

        function populateRoles() {
    console.log('Fetching roles...');
    axios.get('{{ route("role.index") }}')
        .then(function(response) {
            console.log('Roles fetched successfully:', response.data);

            // Ensure the response contains roles as an array
            if (Array.isArray(response.data)) {
                var roles = response.data;
                var roleSelect = document.getElementById('role');

                roleSelect.innerHTML = '';

                roles.forEach(function(role) {
                    var option = document.createElement('option');
                    option.value = role.id;
                    option.text = role.role_name;
                    roleSelect.appendChild(option);
                });
            } else {
                console.error('Invalid roles data format:', response.data);
            }
        })
        .catch(function(error) {
            console.error('Error fetching roles:', error);
        });
}

    

    // Call the function to populate roles when the page loads
    window.onload = function() {
        populateRoles();
    };
    </script>

    <!-- Include CSS styles for the pop-up -->
    <style>
        /* Styles for the pop-up form */
        .form-popup {
            display: none;
            position: fixed;
            top: 50%; /* Align the top of the popup to the middle of the viewport */
            left: 50%; /* Align the left edge of the popup to the middle of the viewport */
            transform: translate(-50%, -50%); /* Center the popup precisely */
            border: 3px solid #f1f1f1;
            z-index: 9;
            background-color: #fefefe;
            width: 300px;
            padding: 20px;
        }

        .form-container {
            max-width: 100%;
            padding: 10px;
            background-color: white;
        }

        /* Full-width input fields */
        .form-container input[type=text],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
        }

        /* Set a style for the buttons */
        .form-container .btn {
            background-color: #4a82b0;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
        }

        .form-container .btn:hover {
            background-color: #000080;
        }

        .cancel {
            background-color: #f44336;
        }
    </style>
@endsection

<!-- Include necessary scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
