<div id="external-events">
  <div id='calendar-container' wire:ignore>
    <div id='calendar'></div>
  </div>
</div>


@push('scripts')

    <script>
    document.addEventListener('livewire:load', function() {

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl, {
            itemSelector: '.fc-event'
        });

        // initialize the calendar
        // -----------------------------------------------------------------

        var calendar = new Calendar(calendarEl, {
            aspectRatio: 2,
            selectable: true,
            nowIndicator: true,
            slotMinTime: "06:00:00",
            slotMaxTime: "23:00:00",
            expandRows: true,
            editable: true,
            businessHours: [ // specify an array instead
                {
                    daysOfWeek: [ 1, 2, 3, 4, 5 ], // Monday - Friday
                    startTime: '06:00', // 8am
                    endTime: '23:00' // 6pm
                },
                {
                    daysOfWeek: [ 6 ], // Thursday, Friday
                    startTime: '08:00', // 10am
                    endTime: '13:00' // 4pm
                }
            ],
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            eventDidMount: function(info) {

                // info.el.innerHTML = `${info.event.title}`;
                tippy(info.el, {
                    content: /*html*/`<div class="py-8">
                        ${info.event.extendedProps.description ? info.event.extendedProps.description : ''}
                    </div>` ,
                    allowHTML: true,
                });
            },
            locale: 'pt-br',
        });


        calendar.addEventSource( {
            url: '/admin/calendar/events',
            extraParams: function(elm) {
                return {
                    name: @this.name,
                };
            }
        });

        calendar.render();

        calendar.updateSize();

        @this.on(`refreshCalendar`, () => {
            calendar.refetchEvents()
        });
    });

    </script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.4.0/main.min.css">

@endpush
