<div>
    <div>
        <div class="query">
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="{{__('Search projects')}}..."
                class="focus:ring-blue-500 w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2" />
            <select wire:change="selectQuery($event.target.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="selected" id="selected" form="selected">
                <option value="">{{__('All Projects')}}</option>
                <option value="after">{{__('After today')}}</option>
                <option value="before">{{__('Before today')}}</option>
                <option value="current">{{__('Current Projects')}}</option>
            </select>
        </div>
        <div class="w-full flex-col justify-start items-start gap-3.5 flex p-4">
            <div class="w-full justify-between items-center inline-flex">
                <div class="inline-flex rounded-md shadow-xs" role="group">
                    @if(Auth::user()->is_admin !== 0)
                    <a href="{{ route('projects.create') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                        {{__('Create Project')}}
                    </a>
                    <button type="button" wire:click="deleteSession()" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                        {{__('Clear open Projects')}}
                    </button>
                    @else
                    <button type="button" wire:click="deleteSession()" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                        {{__('Clear open Projects')}}
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-black dark:text-gray-400">
            <thead class="text-xs text-black uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">{{__('Name')}}</th>
                    <th scope="col" class="px-64 py-3">{{__('Description')}}</th>
                    <th scope="col" class="px-2 py-3">{{__('Action')}}</th>
                </tr>
            </thead>
            @foreach($projects as $project)
            <tbody wire:key="project-{{$project->id}}" x-data="{show_tasks: @json(in_array($project->id, Session::get('open_projects',[])))}" @refresh_component.window="$wire.call('$refresh')">
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                    <th wire:click="toggleProject({{$project->id}})" class="w-3xs py-3">{{ $project->name }}</th>
                    <td class="w-xl break-all py-3"><a href="{{ route('projects.show', ['project_id' => $project->id]) }}">{{ $project->description }}</a></td>
                    <td class="w-20 py-3">
                        @if(Auth::user()->is_admin !== 0)
                        <a class="text-green-600 dark:text-lime-400" href="{{ route('tasks.create', ['project_id' => $project->id]) }}">{{__('Add task')}}</a>
                        <a class="text-blue-600 dark:text-sky-400" href="{{ route('projects.edit', ['project_id' => $project->id]) }}">{{__('Edit')}}</a>
                        <form class="text-red-600 dark:text-rose-400" method="POST" action="{{ route('projects.destroy', ['project_id' => $project->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                        </form>
                        @endif
                    </td>
                </tr>
                <tr x-bind:class="! show_tasks ? 'hidden' : ''">
                    <td class="w-full" colspan="3">
                        @livewire('task-show', ['project_id' => $project->id], key('project-'.$project->id))
                    </td>
                </tr>
            </tbody>

            @endforeach
        </table>
    </div>
</div>