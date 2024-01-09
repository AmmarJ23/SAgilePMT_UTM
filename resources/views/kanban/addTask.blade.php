<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url(images/kanbanAgile.jpg);
        background-position: center;
        background-size: cover;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    input,
    select,
    textarea {
        width: calc(100% - 16px);
        padding: 8px;
        margin-bottom: 16px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>

    <form id="addTaskForm" action="{{route('kanban.storeTask')}}" method="post">
        @csrf

        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="description">Description:</label>
        <textarea name="description"></textarea>

        <div style="display: flex; justify-content: space-between;">
            <div style="width: 48%;">
                <label for="order">Order:</label>
                <input type="number" name="order" required>
            </div>

            <div style="width: 48%;">
                <label for="user_name">User Name:</label>
                <select name="user_name" required>
                    @foreach ($userList as $user)
                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <input type="hidden" name="status_id" value="{{ $status_id }}">

        <div style="display: flex; justify-content: space-between;">
            <div style="width: 48%;">
                <label for="userstory">User Story:</label>
                <select name="userstory" required>
                    @foreach ($userStories as $userStory)
                    <option value="{{ $userStory->user_story }}">{{ $userStory->user_story }}</option>
                    @endforeach
                </select>
            </div>

            <div style="width: 48%;">
                <input type="hidden" name="sprint_id" value="{{ $sprint_id }}">
            </div>
        </div>

        <input type="hidden" name="sprintProjId" value="{{ $sprintProjId }}">


        <div style="display: flex; justify-content: space-between;">
            <div style="width: 48%;">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" required>
                <div class="error">
                    <font color="red" size="2">{{ $errors->first('start_date') }}</p>
                    </font>
                </div>
                {{ $sprint->sprint_name }} Start Date: {{ date('d F Y', strtotime($sprint->start_sprint)) }}
            </div>

            <div style="width: 48%;">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" required>
                <div class="error">
                    <font color="red" size="2">{{ $errors->first('end_date') }}</p>
                    </font>
                </div>
                {{ $sprint->sprint_name }} End Date: {{ date('d F Y', strtotime($sprint->end_sprint)) }}
            </div>
        </div>

        <br>

        <button type="submit">Submit</button>

    </form>

</body>

</html>