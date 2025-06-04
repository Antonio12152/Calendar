<table class="w-full text-sm text-left rtl:text-right text-black dark:text-gray-400">
    <thead class="text-xs text-black uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-500">
        <tr>
            <th scope="col" class="px-4 py-3">Task Name</th>
            <th scope="col" class="px-12 py-3">Task Description</th>
            <th scope="col" class="px-2 py-3">Task Action</th>
        </tr>
    </thead>
    @foreach($tasks as $task)
    <tbody x-data="{show_jobs:@json(in_array($task->id, Session::get('open_tasks',[])))}">
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
            <th x-on:click="show_jobs = !show_jobs" wire:click="toggleTask({{$task->id}})"> {{ $task->name }}</th>

            <td><a href="{{ route('tasks.show', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">{{ $task->description }}</a></td>

            <td>
                <a class="text-green-600 dark:text-lime-400" href="{{ route('jobs.create', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">Add job</a>
                <a class="text-blue-600 dark:text-sky-400" href="{{ route('tasks.edit', ['project_id' => $task->project_id, 'task_id'=>$task->id]) }}">Edit</a>
                <form class="text-red-600 dark:text-rose-400" method="POST" action="{{ route('tasks.destroy', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        <tr x-bind:class="!show_jobs ? 'hidden' : ''">
            <td class="w-full" colspan="3">
                @foreach($task->job as $job)
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-gray-400">
                    <thead class="text-xs text-black uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-500">
                        <tr>
                            <th scope="col" class="px-16 py-3">Job Description</th>
                            <th scope="col" class="px-2 py-3">Job Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="{{ route('tasks.show', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">{{ $job->description }}</a></td>
                            <td>
                                @livewire('job-assign', ['job_id'=>$job->id], key($job->id))
                                <a class="text-blue-600 dark:text-sky-400" href="{{ route('jobs.edit', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">Edit Job</a>
                                <form class="text-red-600 dark:text-rose-400" method="POST" action="{{ route('jobs.destroy', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')">Delete Job</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </td>
        </tr>
    </tbody>
    @endforeach
</table>