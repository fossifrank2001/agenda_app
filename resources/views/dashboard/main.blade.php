@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <style>
        .fc-daygrid-day-frame {
            border: 1px solid #ddd;
            overflow: hidden;
        }

        .fc-daygrid-day-events {
            overflow-y: auto;
        }
        *::-webkit-scrollbar {
            width: 8px!important;
            background-color: transparent!important;
        }

        *::-webkit-scrollbar-thumb {
            background-color: #ffffff!important;
            border-radius: 4px!important;
        }
    </style>


    @php
        /**
         * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Activity> $activities
         */
        $events = $activities->map(function(\App\Models\Activity $activity) {
            return [
                'id' => $activity->id,
                'title' => $activity->name,
                'start' => $activity->start_time,
                'description' => $activity->description,
                'location' => $activity->place,
                'status' => $activity->status,
                'group' => $activity?->group?->name
            ];
        });
         $currentRoute = Route::currentRouteName();
    @endphp

    <div class="container-fluid mt-9">
        <div class="card">
            <div class="card-header">
                <button id="export-pdf" class="btn btn-primary d-flex align-items-center">
                    <i class="ti ti-cloud-download me-1"></i>
                    <span>Exporter en PDF</span>
                </button>
            </div>
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="eventModal_" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Activity details</h5>
                    <button type="button" class="close _close-btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalEventTitle"></span></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p><strong>Start:</strong> <span id="modalEventStart"></span></p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <p><strong>Status:</strong> <span id="modalEventStatus"></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p><strong>Place:</strong> <span id="modalEventLocation"></span></p>
                        </div>
                    </div>
                    <p><strong>Group:</strong> <span id="modalEventGroup"></span></p>
                </div>
                <div class="modal-footer">
                    <a href="#" id="modalEventLink" class="btn btn-primary">See more...</a>
                    <button type="button" class="btn btn-secondary _close-btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = @json($events);


            function formatTime(event) {
                var startTime = new Date(event.start);

                var hours = startTime.getHours();
                var minutes = ('0' + startTime.getMinutes()).slice(-2);

                return (hours === 0 && minutes === "00") ? null : (hours + 'h' + minutes);
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events,
                eventContent: function(arg) {
                    var event = arg.event;
                    var eventTime = formatTime(event);
                    var eventTitle = event.title;
                    var groupEvent = event.extendedProps.group;
                    var eventLocation = event.extendedProps.location;

                    var html = `
                    <div class="d-flex flex-column w-100">
                        <div class="fc-event-time-chip badge badge-${event.extendedProps.status === 'processing'? 'success': 'danger'} rounded-pill text-truncate" style="max-width: 100%!important; width: auto!important; white-space: normal!important; line-height: 16px; font-size: 12px">${groupEvent}</div>
                        <div class="fc-event-title fw-bolder my-3 text-truncate" style="max-width: 100%!important; width: auto!important; white-space: normal!important;">${eventTitle}</div>
                        <div class="fc-event-location text-truncate" style="max-width: 100%!important; width: auto!important; white-space: normal!important;">${eventLocation ?? ''}</div>
                        <div class="fc-event-location text-primary ${eventTime ? '': 'd-none'}">->> ${eventTime} <<-</div>
                    </div>
                `;

                    return { html: html };
                },
                eventClick: function(info) {
                    const getStatus = (status) => {
                        let element;
                        if(status === 'processing'){
                            element =`<span class="badge text-bg-success">${status}</span>`
                        }else{
                            element = `<span class="badge text-bg-danger">${status}</span>`
                        }

                        return element;
                    };

                    document.getElementById('modalEventTitle').innerText = info.event.title;
                    document.getElementById('modalEventStart').innerText =  info.event?.start?.toLocaleString();
                    document.getElementById('modalEventLocation').innerText = info.event.extendedProps.location;
                    document.getElementById('modalEventStatus').innerHTML = getStatus(info.event.extendedProps.status);
                    document.getElementById('modalEventGroup').innerText = info.event.extendedProps.group;

                    document.getElementById('modalEventLink').href = '/dashboard/activities/' + info.event.id;

                    $('#eventModal_').modal('show');
                }
            });
            calendar.render();

            document.querySelectorAll('._close-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const modal = document.getElementById('eventModal_');
                    $(modal).modal('hide');
                });
            });

            document.getElementById('export-pdf').addEventListener('click', function() {
                // Ajuster la hauteur pour capturer toute la zone du calendrier
                var calendarHeight = calendarEl.scrollHeight;
                var calendarWidth = calendarEl.scrollWidth;

                console.log(calendarWidth, calendarHeight);

                domtoimage.toPng(calendarEl, {
                    width: calendarWidth,
                    height: calendarHeight,
                    style: {
                        transform: 'translate(-5px, -10px) scale(.9)',
                    }
                })
                    .then(function(dataUrl) {
                        var pdf = new jsPDF('landscape', 'pt', 'a4');
                        var img = new Image();
                        img.src = dataUrl;
                        img.onload = function() {
                            var pdfWidth = pdf.internal.pageSize.getWidth();
                            var pdfHeight = ((img.height * pdfWidth) / img.width) - 100;
                            pdf.addImage(dataUrl, 'PNG', 0, 0, pdfWidth, pdfHeight);
                            pdf.save('calendrier.pdf');
                        };
                    })
                    .catch(function(error) {
                        console.error('Erreur lors de la conversion en image:', error);
                    });
            });

        });

    </script>
@endsection
