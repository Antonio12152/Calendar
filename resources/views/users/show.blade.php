<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Jobs') }}
        </h2>
    </x-slot>

    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($jobs as $job)
            <div class="w-full lg border-2 border-solid border-indigo-600 bg-indigo-100 rounded-md overflow-hidden h-64">
                <div class="p-2">
                    <a class="text-xl text-gray-900 dark:text-white" href="{{ route('projects.show', ['project_id' => $job->project->id]) }}">{{$job->project->name}}</a>
                    <br/>
                    <a class="text-xl text-gray-900 dark:text-white" href="{{ route('tasks.show', ['project_id' => $job->project->id, 'task_id' => $job->task->id]) }}">{{$job->task->name}}</a>
                    <br/>
                    <a class="break-all" href="{{ route('tasks.show', ['project_id' => $job->project->id, 'task_id' => $job->task->id]) }}">{{$job->description}}</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    {{--alpine stuff, if duplicate delete--}}
</x-app-layout>