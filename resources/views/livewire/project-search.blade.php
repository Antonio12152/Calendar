<div>
    {{--href="{{ route('projects.show', ['project_id' => $project->id]) }}" getFromSession() {
    if(in_array($project->id, Session::get('open_projects'))){
    show_tasks:true
    }
    }--}}
    <div>
        <div class="query">
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search projects..."
                class="focus:ring-blue-500 w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2" />
        </div>
        <div>
            <a href="{{ route('projects.create') }}">Create new projects (Only admin)</a>
        </div>

    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-black dark:text-gray-400">
            <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">Name</th>
                    <th scope="col" class="px-16 py-3">Description</th>
                    <th scope="col" class="px-1 py-3">Action</th>
                </tr>
            </thead>
            @foreach($projects as $project)
            <tbody x-data="{
            show_tasks:false,
            }">
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th wire:click="toggleProject($project->id)" x-on:click="show_tasks = !show_tasks">{{ $project->name }}</th>

                    <td>{{ $project->description }}</td>
                    <td x-show="show_tasks">Visible</td>
                    {{dd(in_array($project->id, Session::get('open_projects')))}}
                    <td>

                        <a class="text-green-600 dark:text-lime-400" href="{{ route('tasks.create', ['project_id' => $project->id]) }}">Add task</a>
                        <a class="text-blue-600 dark:text-sky-400" href="{{ route('projects.edit', ['project_id' => $project->id]) }}">Edit</a>
                        <form class="text-red-600 dark:text-rose-400" method="POST" action="{{ route('projects.destroy', ['project_id' => $project->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr x-bind:class="! show_tasks ? 'hidden' : ''">
                    <td class="w-full" colspan="3">
                        @livewire('task-show', ['project_id' => $project->id])
                    </td>
                </tr>
            </tbody>

            @endforeach
        </table>
    </div>
</div>