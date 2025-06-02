<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" wire:submit.prevent="save">
                    @csrf
                    @method('PUT')
                    <div>
                        <div>
                            <label for="name">Name of Project:</label>
                        </div>
                        <input type="text" name="name" id="name" wire:model="name" value="{{ $project->name }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <div>
                            <label for="description">Description:</label>
                        </div>
                        <input type="text" name="description" id="description" wire:model="description" value="{{ $project->description }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <div>
                            <label for="start">Start:</label>
                        </div>
                        <input type="datetime-local" name="start" id="start" wire:model="start" value="{{ $project->start }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <div>
                            <label for="end">End:</label>
                        </div>
                        <input type="datetime-local" name="end" id="end" wire:model="end" value="{{ $project->end }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>