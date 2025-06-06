<table class="w-full text-sm text-left rtl:text-right text-black dark:text-gray-400">
    <thead class="text-xs text-black uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-500">
        <tr>
            <th scope="col" class="px-4 py-3">{{__('Task')}} {{__('Name')}}</th>
            <th scope="col" class="px-64 py-3">{{__('Task')}} {{__('Description')}}</th>
            <th scope="col" class="px-2 py-3">{{__('Task')}} {{__('Action')}}</th>
        </tr>
    </thead>
    @foreach($tasks as $task)
    <tbody x-data="{show_jobs:@json(in_array($task->id, Session::get('open_tasks',[])))}" x-on:mousemove="$wire.refreshTask()">
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
            <th wire:click="toggleTask({{$task->id}})" class="w-3xs py-3"> {{ $task->name }}</th>

            <td class="w-xl py-3"><a href="{{ route('tasks.show', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">{{ $task->description }}</a></td>

            <td class="w-3xs py-3">
                <a class="text-green-600 dark:text-lime-400" href="{{ route('jobs.create', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">{{__('Add job')}}</a>
                <a class="text-blue-600 dark:text-sky-400" href="{{ route('tasks.edit', ['project_id' => $task->project_id, 'task_id'=>$task->id]) }}">{{__('Edit')}}</a>
                <form class="text-red-600 dark:text-rose-400" method="POST" action="{{ route('tasks.destroy', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                </form>
            </td>
        </tr>
        <tr x-bind:class="!show_jobs ? 'hidden' : ''">
            <td class="w-full" colspan="3">
                @foreach($task->job as $job)
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-gray-400">
                    <thead class="text-xs text-black uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-500">
                        <tr>
                            <th scope="col" class="px-16 py-3">{{__('Job')}} {{__('Description')}}</th>
                            <th scope="col" class="px-2 py-3">{{__('Job')}} {{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="overflow-hidden"><a href="{{ route('tasks.show', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">{{ $job->description }}</a></td>
                            <td>
                                @livewire('job-assign', ['job_id'=>$job->id], key($job->id))
                                <a class="text-blue-600 dark:text-sky-400" href="{{ route('jobs.edit', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">{{__('Edit')}}</a>
                                <form class="text-red-600 dark:text-rose-400" method="POST" action="{{ route('jobs.destroy', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
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