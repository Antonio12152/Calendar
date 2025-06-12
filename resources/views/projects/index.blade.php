<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <div class="justify-start items-center gap-2.5 flex">
            <div class="flex-col justify-start items-start gap-1 inline-flex">
                <a href="{{ route('projects.create') }}">{{__('Create Project')}}</a>
                <a href="{{ route('jobs.create') }}">{{__('Add job')}}</a>
            </div>
        </div>
        <div id="calendar"></div>
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
                events: @json($projects),
                height: 'auto',
                displayEventEnd: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                eventClick: function(info) {
                    window.location.href = `projects/${info.event.id}`;
                },
                eventDidMount: function(info) {
                    const tasks = info.event.extendedProps.tasks;
                    if (!tasks || tasks.length == 0) return;
                    const data = tasks.map(task => {
                        return `<div>
                                    <a href="/projects/${info.event.id}/tasks/${task.id}">${task.title}</a>
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