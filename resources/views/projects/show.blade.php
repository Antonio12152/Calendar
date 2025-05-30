<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Show') }}
        </h2>
    </x-slot>

    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <a href="{{ route('projects.edit', ['project_id' => $project->id]) }}">Edit</a>

        <form method="POST" action="{{ route('projects.destroy', ['project_id' => $project->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
        </form>

        <div class="">
            <br />
            {{ $project->id }}
            <br />
            {{ $project->name }}
            <br />
            {{ $project->description }}
        </div>
        <br />
        <div class="">
            <label for="Tasks">Tasks:</label>
            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}">Add task</a>
            <br />
            @foreach($tasks as $task)
            <div class="">
                <a href="{{ route('tasks.show', ['task_id' => $task->id,'project_id' => $project->id]) }}">
                    {{ $task->id }}
                    {{ $task->name }}
                    <br />
                    {{ $task->description }}
                    <br />
                </a>
                <div>
                    <a href="{{ route('tasks.edit', ['task_id'=>$task->id, 'project_id' => $project->id]) }}">Edit Task</a>
                    <form method="POST" action="{{ route('tasks.destroy', ['task_id' => $task->id, 'project_id' => $project->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete Task</button>
                    </form>
                </div>
            </div>
            <br />
            @endforeach

        </div>
    </section>
</x-app-layout>