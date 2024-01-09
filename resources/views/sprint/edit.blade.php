<!--Edit Sprint Page-->
@extends('layouts.app2')
@include('inc.style')
@include('inc.navbar')

@section('content')
@include('inc.title')
<br><br>
<form action="{{route('sprints.update', $sprint)}}" method="post">
    
    @csrf
 
    Sprint Title :<input type="text" name="sprint_name" style="margin-left:2.5em" value="{{$sprint->sprint_name}}">
    <br><br><br>

    Description :<input type="text" name="sprint_desc" style="margin-left:2.6em" value="{{$sprint->sprint_desc}}">
    <div class="error"><font color="red" size="2">{{ $errors->first('sprint_desc') }}</p></font></div>
    <br>

    @if ($sprintStarted)
        <span style="color: red;">(Start date and end date cannot be changed once the sprint has started)</span><br><br>
    @endif

    Start Date :<input type="date" name="start_sprint" style="margin-left:2.6em" value="{{$sprint->start_sprint}}"@if ($sprintStarted) readonly @endif>
    <div class="error"><font color="red" size="2">{{ $errors->first('start_sprint') }}</p></font></div>
    {{ $project->proj_name }} Start Date: {{ date('d F Y', strtotime($project->start_date)) }}
    <br><br><br>

    Completion Date :<input type="date" name="end_sprint" style="margin-left:2.6em" value="{{$sprint->end_sprint}}"@if ($sprintStarted) readonly @endif>
    <div class="error"><font color="red" size="2">{{ $errors->first('end_sprint') }}</p></font></div>
    {{ $project->proj_name }} End Date: {{ date('d F Y', strtotime($project->end_date)) }}
    <br><br><br>

    {{-- <input type="hidden" name="sprint_id" value="{{$sprint->sprint_id}}">  --}}

    <button type="submit" >Update</button> 
        
         {{-- <button type="submit", formaction="{{route('profeature.index2', $sprint)}}", method="post">Update</button> --}}
        {{-- <button type="submit", formaction="{{route('sprints.destroy', $sprint)}}", method="post" onclick="return confirm('Are you sure to delete this sprint?')">Delete</button> --}}
</form>
    <br><br><br>

@endsection

