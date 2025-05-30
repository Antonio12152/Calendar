<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Edit') }}
        </h2>
    </x-slot>

    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        @livewire('project-edit', ['project' => $project])
    </section>
    @livewireScripts @vite('resources/js/app.js')
</x-app-layout>