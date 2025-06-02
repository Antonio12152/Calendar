<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks Show') }}
        </h2>
    </x-slot>

    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <div>
            <a href="{{ route('tasks.edit', ['project_id' => $task->project_id, 'task_id'=>$task->id]) }}">Edit Task</a>
            <form method="POST" action="{{ route('tasks.destroy', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')">Delete Task</button>
            </form>
        </div>
        <div class="">
            <br />
            {{ $task->id }}
            <br />
            {{ $task->name }}
            <br />
            {{ $task->description }}
        </div>
        <div class="">
            <label for="Jobs">Jobs:</label>
            <a href="{{ route('jobs.create', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">Add job</a>
            <br />
            @foreach($jobs as $job)
            <div class="">
                {{ $job->id }}
                <br />
                {{ $job->description }}
                <br />
                <div>
                    @livewire('job-assign',['job_id'=>$job->id])
                    <br />
                    <a href="{{ route('jobs.edit', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">Edit Job</a>
                    <form method="POST" action="{{ route('jobs.destroy', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete Job</button>
                    </form>
                </div>
            </div>
            <br />
            @endforeach
        </div>
    </section>
</x-app-layout>