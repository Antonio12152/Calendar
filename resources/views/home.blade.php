<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        @livewire('project-search')
    </section>
</x-app-layout>