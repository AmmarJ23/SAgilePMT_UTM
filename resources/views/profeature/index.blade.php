@extends('layouts.app2')

<?php
    $themeConfig = app(\App\Services\ThemeConfig::class);
    $styleFile = $themeConfig->getThemeCssFile();
?>

@include("{$styleFile}")
@include('inc.success')
@include('inc.dashboard')
@include('inc.navbar')

@section('content')
    @include('inc.title')
    <br>

    <table>
        <!-- Table Header -->
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Team</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Backlog</th>
            <th>Sprint</th>
            <th>Forum</th>
            <th>Defect Tracking</th>
        </tr>

        <!-- Check if projects exist -->
        @if ($pros->isEmpty())
            <tr>
                <td colspan="10">
                    <h3>There are no projects yet:</h3>

                </td>
            </tr>
        @else
            <!-- Loop through existing projects -->
            @foreach($pros as $project)
    <tr> 
        <!-- Display project details -->
        <td>{{ $project->proj_name }}</td>
        <td>{{ $project->proj_desc }}</td>
        <td>{{ date('d F Y', strtotime($project->start_date)) }}</td>
        <td>{{ date('d F Y', strtotime($project->end_date)) }}</td>
       <!-- Display team name -->
<td><button type="submit" class="btn"><a href="{{ route('team.index') }}">{{ $project->team_name }}</a></td>
<!-- Rest of the code remains the same -->

        <!-- Edit link -->
        <td><button type="submit" class="btn"><a href="{{ route('projects.edit', $project->id) }}">Edit</a></td>
        <!-- Delete form -->
        <td><form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="margin-block-end: 0em">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
            </form></td>
        <!-- Links related to the project -->
        <td><button type="submit" class="btn"><a href="{{ route('backlog.index', $project->id) }}">View</a></td>
        <td><button type="submit" class="btn"><a href="{{ action('ProductFeatureController@index2', $project->proj_name) }}">View</a></td>
        <td><button type="submit" class="btn"><a href="{{ action('ForumController@index') }}">View</a></td>
        <td><button type="submit" class="btn"><a href="">View</a></td>
    </tr>
@endforeach

        @endif
    </table>
    <br><br><br>

    <!-- Button to create a new project -->
    <button type="submit"><a href="{{ route('projects.create') }}">Add Project</a></button>
@endsection
