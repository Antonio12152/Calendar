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
                                    <a href="{{ route('projects.edit', ['project_id' => $project->id]) }}">{{__('Edit')}}</a>
                                    <form method="POST" action="{{ route('projects.destroy', ['project_id' => $project->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                                    </form>
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


                    <div
                        class="w-full lg:p-8 p-5 bg-white rounded-3xl border border-gray-200 flex-col justify-start items-start flex">
                        <div class="w-full flex-col justify-start items-start gap-3.5 flex">
                            <div class="w-full justify-between items-center inline-flex">
                                <div class="justify-start items-center gap-2.5 flex">
                                    <div class="flex-col justify-start items-start gap-1 inline-flex">
                                        <h5 class="text-gray-900 font-semibold leading-snug">{{ $task->name }}</h5>
                                    </div>
                                </div>
                                <div class="justify-end">
                                    <a href="{{ route('tasks.edit', ['project_id' => $task->project_id, 'task_id'=>$task->id]) }}">{{__('Edit')}}</a>
                                    <form method="POST" action="{{ route('tasks.destroy', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                                    </form>
                                </div>
                            </div>
                            <p class="break-all text-gray-800 font-normal leading-snug">{{ $task->description }}</p>
                        </div>
                    </div>

                    <div>
                        <label for="Jobs">{{__('Job')}}:</label>
                        <br />
                        <a href="{{ route('jobs.create', ['project_id' => $task->project_id, 'task_id' => $task->id]) }}">{{__('Add job')}}</a>
                    </div>

                    <div id="calendar"></div>

                    @foreach($jobs as $job)
                    <div class="w-full flex-col justify-start items-start gap-8 flex">
                        <div
                            class="w-full lg:p-8 p-5 bg-white rounded-3xl border border-gray-200 flex-col justify-start items-start flex">
                            <div class="w-full flex-col justify-start items-start gap-3.5 flex">
                                <div class="text-sm">
                                    <h5>{{__('Start')}}</h5>
                                    <p>{{ $job->start }}</p>
                                    <h5>{{__('End')}}</h5>
                                    <p>{{ $job->end }}</p>
                                </div>
                                <p class="break-all text-gray-800 text-m font-normal leading-snug">{{ $job->description }}</p>
                                <div>
                                    @livewire('job-assign',['job_id'=>$job->id])
                                    <a href="{{ route('jobs.edit', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">{{__('Edit')}}</a>
                                    <form method="POST" action="{{ route('jobs.destroy', ['project_id' =>$job->project_id, 'task_id' => $job->task_id,  'job_id' => $job->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Sind Sie sicher?')">{{__('Delete')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </section>


    @push('scripts')
    <script src="{{ Vite::asset('resources/js/fullcalendarCore.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/popper.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/tippy.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                firstDay: 1,
                locale: 'de',
                events: @json($jobs),
                height: 'auto',
                displayEventEnd: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                eventDidMount: function(info) {
                    const jobs = @json($jobs);
                    if (!jobs || jobs.length == 0) return;
                    const data = jobs.map(job => {
                        return `<div>
                                    <p class="break-all">${job.description}</p>
                                </div>`;
                    }).join('');

                    tippy(info.el, {
                        content: data,
                        allowHTML: true,
                        flipBehavior: "flip",
                        interactive: true,
                        delay: [0, 200],
                        hideOnClick: false
                    })
                }
            });
            calendar.render();
        });
    </script>
    <link href="{{ Vite::asset('resources/css/fullcalendarCore.css') }}" rel="stylesheet" />
    <link href="{{ Vite::asset('resources/css/fullcalendarDaygrid.css') }}" rel="stylesheet" />
    <link href="{{ Vite::asset('resources/css/fullcalendarTimegrid.css') }}" rel="stylesheet" />
    @endpush
</x-app-layout>