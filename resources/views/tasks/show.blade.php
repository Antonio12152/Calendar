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
                            <p class="text-gray-800 font-normal leading-snug">{{ $task->description }}</p>
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/core/locales/de"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'de',
                events: @json($jobs),
                height: 700
            });
            calendar.render();
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />
    @endpush
</x-app-layout>