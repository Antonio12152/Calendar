<div>
    <section class="w-full bg-white p-6 shadow-md rounded-lg">
        <div class="justify-start items-center gap-2.5 flex">
            <div class="inline-flex rounded-md shadow-xs" role="group">
                @if(Auth::user()->is_admin !== 0)
                <a href="{{ route('projects.create') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('Create Project')}}
                </a>
                <a href="{{ route('jobs.create') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('Add job')}}
                </a>
                <a href="{{ route('projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('Projects')}}
                </a>
                <a href="{{ route('jobs.index') }}" wire:click="deleteSession()" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('My jobs')}}
                </a>
                @else
                <a href="{{ route('jobs.create') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('Add job')}}
                </a>
                <a href="{{ route('projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('Projects')}}
                </a>
                <a href="{{ route('jobs.index') }}" wire:click="deleteSession()" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    {{__('My jobs')}}
                </a>
                @endif

            </div>
        </div>
        <div id="calendar"></div>
    </section>
    @push('scripts')
    <script src="{{ Vite::asset('resources/js/fullcalendarCore.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/popper.js') }}"></script>
    <script src="{{ Vite::asset('resources/js/tippy.js') }}"></script>
    <script>
        let calendar

        function renderCalendar(events) {
            var calendarEl = document.getElementById('calendar');
            if (calendar) {
                console.log(calendar.getEventSources())
                calendar.removeAllEvents()
                calendar.addEventSource(events)
                return;
            }
            calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                firstDay: 1,
                locale: 'de',
                events: events,
                height: 'auto',
                displayEventEnd: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                eventClick: function(info) {
                    console.log(info.event)
                    window.location = `${window.location.origin}/projects/${info.event.extendedProps.project_id}/tasks/${info.event.extendedProps.task_id}`;
                },
            });
            calendar.render();
        }
        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar(@json($projects))
        });
    </script>
    <link href="{{ Vite::asset('resources/css/fullcalendarCore.css') }}" rel="stylesheet" />
    <link href="{{ Vite::asset('resources/css/fullcalendarDaygrid.css') }}" rel="stylesheet" />
    <link href="{{ Vite::asset('resources/css/fullcalendarTimegrid.css') }}" rel="stylesheet" />
    @endpush
</div>