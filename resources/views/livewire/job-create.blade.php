<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" wire:submit.prevent="save">
                    @csrf
                    <div>
                        <div>
                            <label for="project">{{__('Projects')}}:</label>
                        </div>
                        <select class="p-1 w-56" name="project_select" id="project_select" form="project_select" wire:model="project_id">
                            <option value="" >Select</option>
                            @foreach ($projects as $project)
                            <option value="{{ $project->id }}" @selected($project->id == $project_id)>{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <div>
                            <label for="task">{{__('Tasks')}}:</label>
                        </div>
                        <select class="p-1 w-56" name="task" id="task" form="task">
                            <option value="">{{__('All Projects')}}</option>
                        </select>
                        <div>
                            <label for="description">{{__('Description')}}:</label>
                        </div>
                        <textarea name="description" id="description" wire:model="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('Description')}}..."></textarea>
                        <div>
                            <label for="start">{{__('Start')}}:</label>
                        </div>
                        <input type="datetime-local" name="start" id="start" wire:model="start" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <div>
                            <label for="end">{{__('End')}}:</label>
                        </div>
                        <input type="datetime-local" name="end" id="end" wire:model="end" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>

                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{__('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>