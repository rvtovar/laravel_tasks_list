@extends('layouts.app')

@section('title', 'Task List')
@section('content')
    <nav class="mb-4">
        <a href="{{route('tasks.create')}}" class="btn">Create a Task</a>
    </nav>
    @forelse($tasks as $task)
        <div>
            <a href="{{route('tasks.show', ['task' => $task->id ])}}"
               @class(['line-through font-bold' => $task->completed])
            >
                {{ $task->title }}
            </a>
        </div>
    @empty
        <p>No tasks found</p>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>

    @endif
@endsection
