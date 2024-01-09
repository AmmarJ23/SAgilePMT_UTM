<!-- Main Task Page -->
@extends('layouts.app2')
@include('inc.style')
@include('inc.success')
@include('inc.dashboard')
@include('inc.navbar')

@section('content')
@include('inc.title')
<br>
    <table>
        <tr>
            <th>Task</th>
            <th>Description</th>
            <th>Assigned To</th>
            <th>Status</th>   
            <th>Edit</th> <!--Not Done-->
            <th>Delete</th>
        </tr>

      @forelse($tasks as $task)
        <tr> 
            <th>
              {{$task->title}}
            </th>
            <th>
              {{ $task->description }}
            </th>
            <th>
              {{ $task->user_name }}
            </th>
            <th>

              <?php
                $status = $statuses->firstWhere('id', $task->status_id);
              ?>
  
              {{ $status->title }}
            </th>
            <th>
              <button type="submit"><a href="{{route('tasks.edit', [$task->id])}}">Edit</a></button>
            </th>
            <th>
              <button type="submit"><a href="{{route('tasks.destroy', $task)}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
            </th>

        </tr>
        @empty
        <tr>
          <td colspan="6">No task added yet</td>
        </tr>
        @endforelse

          
      </table>

  <br><br>

      <button type="submit"><a href="{{route('tasks.create', $userstory_id)}}">Add Task</a></button>
      
@endsection