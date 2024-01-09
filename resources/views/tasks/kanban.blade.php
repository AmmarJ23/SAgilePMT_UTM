<!--tasks.kanban.blade.php-->
@extends('layouts.app')
@include('inc.style')

@section('content')

<div class="md:mx-4 relative overflow-hidden">
    <main class="h-full flex flex-col overflow-auto">
        {{-- give selection to choose which project to view kanban --}}
        <table id=userstories>
            <tr>
                <th>Project</th>
                <th>Kanban Board</th>
            </tr>
            
    
          @forelse($pro as $project)
            <tr> 
                <th>
                    {{ $project->proj_name }}
                </th>
                <th>
                    <button type="submit"><a href="{{ route('tasks.viewkanban', ['proj_id' => $project['id']]) }}">View</a></button>
                </th>
            </tr>
    
          @empty
          <tr>
            <td colspan="2">No projects added yet</td>
          </tr>
    
            @endforelse
          </table>
        {{-- <kanban-board :tasks="{{ $tasks }}" :statuses="{{$statuses}}"></kanban-board> --}}
    </main>
</div>
@endsection



