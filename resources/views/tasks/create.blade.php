@extends('layouts.app2')
@include('inc.style')
@include('inc.navbar')

@section('content')
@include('inc.title')

<head>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #495057;
    }

    .container {
        margin-top: 50px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .error {
        margin-top: 5px;
    }

    button {
        background-color: #007bff;
        color: #ffffff;
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

<div class="container">
    <form action="{{ route('tasks.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="userstory_id" value="{{ $userstory_id }}">

        <div class="form-group">
            <label for="title">Task Name:</label>
            <input type="text" name="title" class="form-control">
            <div class="error">
                <font color="red" size="2">{{ $errors->first('title') }}</p>
                </font>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control"></textarea>
            <div class="error">
                <font color="red" size="2">{{ $errors->first('description') }}</p>
                </font>
            </div>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 48%;">
                    <label for="status_id">Status:</label>
                    <select name="status_id" id="status_id" class="form-control">
                        <option value="" selected disabled>Select</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                    </select>
                    <div class="error">
                        <font color="red" size="2">{{ $errors->first('status_id') }}</font>
                    </div>
                </div>

                <div style="width: 48%;">
                    <label for="user_name">Assigned to:</label>
                    <select name="user_name" class="form-control">
                        @foreach($teamlist as $teammember)
                            <option value="{{ $teammember->username }}"
                                    {{ ((isset($teammember->username) && $teammember->username == $teammember->username) ? "selected" : "") }}>
                                {{ $teammember->username }}
                            </option>
                        @endforeach
                    </select>
                    <div class="error">
                        <font color="red" size="2">{{ $errors->first('user_id') }}</p>
                        </font>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between;">
                <div style="width: 48%;">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class="form-control">
                    <div class="error">
                        <font color="red" size="2">{{ $errors->first('start_date') }}</p>
                        </font>
                    </div>
                    {{ $sprint->sprint_name }} Start Date: {{ date('d F Y', strtotime($sprint->start_sprint)) }}
                </div>

                <div style="width: 48%;">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class="form-control">
                    <div class="error">
                        <font color="red" size="2">{{ $errors->first('end_date') }}</p>
                        </font>
                    </div>
                    {{ $sprint->sprint_name }} End Date: {{ date('d F Y', strtotime($sprint->end_sprint)) }}
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Task</button>
        </div>
    </form>
</div>
@endsection
