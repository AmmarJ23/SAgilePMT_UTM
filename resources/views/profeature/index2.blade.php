<!--Sprint Index/Sprint Page-->
@include('inc.success')
@extends('layouts.app2')
@include('inc.style')

@include('inc.dashboard')

@include('inc.navbar')

@section('content')
@include('inc.title')
<br><br>
    {{-- <a href="{{route('profeature.index')}}" class="button">Project List</a> --}}

@csrf
<table id="sprint">
  <tr>
      <th>Sprint Name</th>
      <th>Description</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Kanban</th>
      <th>Burn Down Chart</th>
      <th>Edit</th>
      <th>Delete</th>
      <th>User Story</th>
  </tr>


  
  @forelse($sprints as $sprint)
    <tr>
      <th>
        {{$sprint->sprint_name}}
      </th>

      <th>
        {{$sprint->sprint_desc}}        
      </th>

      <th>
        {{ date('d F Y', strtotime($sprint->start_sprint)) }}
      </th>

      <th>
        {{ date('d F Y', strtotime($sprint->end_sprint)) }}
      </th>

      <th>
        <button type="submit"><a href="{{ route('sprint.kanbanPage', ['proj_id' => $projects->id, 'sprint_id' => $sprint->sprint_id]) }}" class="button">View</a></button>

      </th>

      <th>
      <button type="submit"><a href="{{ route('burnDown.index', ['proj_id' => $projects->id, 'sprint_id' => $sprint->sprint_id]) }}" class="button">View</a></button>

      </th>

      <th>
        <button type="submit"><a href="{{route('sprints.edit', [$sprint->sprint_id])}}">Edit</a></button>
      </th>

      <th>
        <button type="submit"><a href="{{route('sprints.destroy', $sprint)}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sprint?');">Delete</button>
      </th>

      <th>
        <button type="submit"><a href="{{action('ProductFeatureController@index3', $sprint['sprint_id'])}}">View</a></button>
      </th>
    </tr>

  @empty
  <tr>
      <td colspan="7">No sprints added yet</td>
  </tr>
  
  @endforelse
  </table>
  
  <br><br><br>
  
  <button type="submit"><a href="{{route('sprints.create', $projects['proj_name'])}}">Create Sprint</a></button>
 
@endsection