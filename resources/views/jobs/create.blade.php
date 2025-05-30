<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Create') }}
        </h2>
    </x-slot>

    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        @livewire('job-create', ['project_id' => $project_id, 'task_id' => $task_id])
    </section>
    @livewireScripts @vite('resources/js/app.js')
</x-app-layout>