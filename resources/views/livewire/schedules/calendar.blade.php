<style>
    .tui-full-calendar-section-button {
        text-align: center;
    }
    .tui-full-calendar-popup-edit, .tui-full-calendar-popup-vertical-line{
        display:none;
    }
</style>



<div class="row @if ($full) w-100 @endif " id="calendar-section">
    <div class="col-2 @if(!$full) p-0 @endif container-fluid">

        @if(!$full)
            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('schedules.create') }}" class='btn btn-primary m-0 w-100'>AGENDAR</a>
                </div>
            </div>

            <hr>
        @endif

        <div class="row mt-2">
            <div class="col-12">
                <p>Calendários</p>
                <ul class="list-group calendars-list"></ul>
            </div>
        </div>

    </div>
    <div class="col-10">

        @if (!$full)
            <div id="menu" class="mb-2 d-flex justify-content-between">
                <span id="menu-navi" class="d-flex">
                    <button type="button" class="btn btn-primary move-today mr-1" data-action="move-today"  onClick="calendarAction('move-today')">Hoje</button>
                    <button type="button" class="btn btn-primary move-day d-flex align-items-center mr-1" data-action="move-prev" onClick="calendarAction('move-prev')">
                        <i class="material-icons" data-action="move-prev">chevron_left</i>
                    </button>
                    <button type="button" class="btn btn-primary move-day d-flex align-items-center" data-action="move-next"  onClick="calendarAction('move-next')">
                        <i class="material-icons" data-action="move-next">chevron_right</i>
                    </button>
                </span>
                <span id="renderRange" class="render-range font-weight-bold d-flex align-items-center"></span>
                <a  href="{{ route('schedules.print')}}"
                    class="btn btn-primary move-day d-flex align-items-center"
                    target="_blank"
                    id="download">
                    <i class="material-icons" data-action="move-next">insert_photo</i>
                </a>
            </div>
        @endif

        <div id="external-events">
            <div id='calendar-container' wire:ignore>
                <div style='border: 1px solid #fafafa;border-top:none;' id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-loop-schedule" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Detalhes do agendamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        let cal;
        document.addEventListener('livewire:load', function() {
            cal = new Calendar('#calendar', {
                defaultView: 'month', // set 'month'
                month: {
                    daynames: ['Domingo','Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    visibleWeeksCount: 2,
                },
                useDetailPopup: true,
                template: {
                    popupDetailBody: function(schedule) {
                        return schedule.body;
                    },
                    popupEdit: function() {
                        return 'Editar';
                    },
                },
                disableDblClick: true

            });

            cal.on({
                'beforeDeleteSchedule': async function(e){
                    if( confirm(`Deseja remover esse agendamento?`) )
                    {
                        await deleteSchedule(e.schedule.id);

                        window.location.reload();
                    }
                }
            });

            async function deleteSchedule( _id )
            {
                await window.axios.get(`/api/calendar/events/${_id}`).then(function (response){
                });
            }

            async function loadSchedules() {
                await window.axios.get('/api/calendar/events').then(function (response){
                    const {calendars, events} = response.data;
                    cal.createSchedules(events);

                    cal.setCalendars(calendars);
                    generateCalendarsList(calendars);
                });
            }

            function generateCalendarsList( calendars ){
                calendars.map(function( calendar ){
                $(".calendars-list").append(/*html*/`
                    <li class="list-group-item d-flex justify-content-between px-1 py-2" style='font-size: 12px'>
                        <div class="custom-control custom-switch d-flex align-items-center">
                            <input type="checkbox"
                                class="custom-control-input"
                                name="customCalendar"
                                title="Teste"
                                id="customCalendar-${calendar.id}"
                                onClick="toggleCalendar('${calendar.id}', this)"
                                data-content="${calendar.bgColor}"
                                checked>
                            <label class="custom-control-label m-0 p-0"
                                data-content="${calendar.bgColor}"
                                for="customCalendar-${calendar.id}">${calendar.name}</label>
                        </div>
                        <div class="vertical" style='width: 24px; height:24px; background: ${calendar.bgColor}'></div>
                    </li>
                `);

                });
            }

            loadSchedules();
            tippy('[data-tippy-content]');


            @if($full)
                $("body").LoadingOverlay('show');
                setTimeout(function() {
                    generateImage();
                },5000);

            @else
                setRenderRangeText();
            @endif
        });

        function toggleCalendar(calendarId, elm){

            const isToHide = $(elm).is(':checked');
            console.log(calendarId);
            cal.toggleSchedules(calendarId, !isToHide);
        }


        function calendarAction( calAction ){
            switch(calAction){
                case 'move-next':
                    cal.next();
                break;
                case 'move-prev':
                    cal.prev();
                break;
                case 'move-today':
                    cal.today();
                break;
                case 'repeat':
                    alert('teste');
                break;
            }

            setRenderRangeText();
        }


        function setRenderRangeText() {
            var renderRange = document.getElementById('renderRange');
            var options = cal.getOptions();
            var viewName = cal.getViewName();
            var html = [];
            if (viewName === 'day') {
                html.push(moment(cal.getDate().getTime()).format('DD/MM/YYYY'));
            } else if (viewName === 'month' &&
                (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
                html.push(moment(cal.getDate().getTime()).format('MM/YYYY'));
            } else {
                html.push(moment(cal.getDateRangeStart().getTime()).format('DD/MM/YYYY'));
                html.push(' ~ ');
                html.push(moment(cal.getDateRangeEnd().getTime()).format(' DD/MM'));
            }
            renderRange.innerHTML = html.join('');
        }

        function generateImage(){
            html2canvas(document.querySelector("#calendar-section")).then(function(canvas) {
                saveAs(canvas.toDataURL(), 'AGENDA.png');
                $("body").LoadingOverlay('hide');
            });
        }


        function saveAs(uri, filename) {

            var link = document.createElement('a');

            if (typeof link.download === 'string') {

                link.href = uri;
                link.download = filename;

                //Firefox requires the link to be in the body
                document.body.appendChild(link);

                //simulate click
                link.click();

                //remove the link when done
                document.body.removeChild(link);

            } else {

                window.open(uri);


            }
        }
    </script>
@endpush
