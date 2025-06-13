<div>
    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <div class="justify-start items-center gap-2.5 flex">
            <div class="flex-col justify-start items-start gap-1 inline-flex">
                <a href="{{ route('projects.create') }}">{{__('Create Project')}}</a>
                <a href="{{ route('jobs.create') }}">{{__('Add job')}}</a>
            </div>
            <div class="flex-col justify-end items-end gap-1 inline-flex">
                <select wire:change="selectQuery($event.target.value)" class="p-1 w-56" name="selected" id="selected" form="selected">
                    <option value="">{{__('Projects')}}</option>
                    <option value="jobs">{{__('My jobs')}}</option>
                </select>
            </div>
        </div>
        <div id="calendar"></div>
        {{$projects}}
    </section>
    @push('scripts')
    <script src="{{ Vite::asset('resources/js/fullcalendarCore.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/popper.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/tippy.js') }}"></script>
    <script>
        function cal() {
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
        }
        document.addEventListener('DOMContentLoaded', function() {
            cal()
        });
        const form = document.getElementById("selected");
        form.addEventListener("change", (e) => {
            cal()
        });
    </script>
    <link href="{{ Vite::asset('resources/css/fullcalendarCore.css') }}" rel="stylesheet" />
    <link href="{{ Vite::asset('resources/css/fullcalendarDaygrid.css') }}" rel="stylesheet" />
    <link href="{{ Vite::asset('resources/css/fullcalendarTimegrid.css') }}" rel="stylesheet" />
    @endpush
</div>