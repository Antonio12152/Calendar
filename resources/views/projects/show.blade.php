<x-app-layout>
    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <section class="py-24 relative">
            <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
                <div class="w-full flex-col justify-start items-start lg:gap-14 gap-7 inline-flex">
                    <div
                        class="w-full lg:p-8 p-5 bg-white rounded-3xl border border-gray-200 flex-col justify-start items-start flex">
                        <div class="w-full flex-col justify-start items-start gap-3.5 flex">
                            <div class="w-full justify-between items-center inline-flex">
                                <div class="justify-start items-center gap-2.5 flex">
                                    <div class="flex-col justify-start items-start gap-1 inline-flex">
                                        <h5 class="text-dark font-semibold leading-snug">{{ $project->name }}</h5>
                                    </div>
                                </div>
                                <div class="justify-end">
                                    @if(Auth::user()->is_admin !== 0)
                                    <a href="{{ route('projects.edit', ['project_id' => $project->id]) }}">{{__('Edit')}}</a>
                                    <form method="POST" action="{{ route('projects.destroy', ['project_id' => $project->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h5>{{__('Start')}}</h5>
                                <p>{{ $project->start }}</p>
                                <h5>{{__('End')}}</h5>
                                <p>{{ $project->end }}</p>
                            </div>
                            <p class="text-dark font-normal leading-snug break-all">{{ $project->description }}</p>
                        </div>
                    </div>
                    @if(Auth::user()->is_admin !== 0)
                    <div>
                        <label for="Tasks">{{__('Task')}}:</label>
                        <br />
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}">{{__('Add task')}}</a>
                    </div>
                    @endif
                    @foreach($tasks as $task)
                    <div class="w-full flex-col justify-start items-start gap-8 flex">
                        <div
                            class="w-full lg:p-8 p-5 bg-white rounded-3xl border border-gray-200 flex-col justify-start items-start flex">
                            <div class="w-full flex-col justify-start items-start gap-3.5 flex">
                                <div class="w-full justify-between items-center inline-flex">
                                    <div class="justify-start items-center gap-2.5 flex">
                                        <div class="flex-col justify-start items-start gap-1 inline-flex">
                                            <a href="{{ route('tasks.show', ['task_id' => $task->id,'project_id' => $project->id]) }}">
                                                <h5 class="text-gray-900 font-semibold leading-snug">{{ $task->name }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="justify-end">
                                        @if(Auth::user()->is_admin !== 0)
                                        <a href="{{ route('tasks.edit', ['task_id'=>$task->id, 'project_id' => $project->id]) }}">{{__('Edit')}}</a>
                                        <form method="POST" action="{{ route('tasks.destroy', ['task_id' => $task->id, 'project_id' => $project->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-gray-800 font-normal leading-snug break-all"><a href="{{ route('tasks.show', ['task_id' => $task->id,'project_id' => $project->id]) }}">{{ $task->description }}</a></p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </section>
    </section>
</x-app-layout>