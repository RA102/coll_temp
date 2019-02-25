$(document).ready(function() {

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        firstDay: 1,
        defaultDate: moment().format('YYYYMMDD'),
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectHelper: true,
        slotLabelFormat: 'HH:mm',
        timeFormat: 'HH:mm',
        select: function(start, end) {
            eventData = {
                id: 'new',
                title: '',
                start: start,
                end: end,
            };
            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

            $('#modal-lesson-create').modal({backdrop: 'static', keyboard: false});
            $('#modal-lesson-create').find('#start_date').val(start.format('YYYY-MM-DD HH:mm:ss'));
            $('#modal-lesson-create').find('#end_date').val(end.format('YYYY-MM-DD HH:mm:ss'));

            // }
            // $('#calendar').fullCalendar('unselect');
        },
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        eventSources: [

            // your event source
            {
                url: feedUrl, // use the `url` property
                color: 'yellow',    // an option!
                textColor: 'black'  // an option!
            }

            // any other sources...

        ],
        events: [],
        eventClick: function(event) {
            // opens events in a popup window
            console.log(event);
        },
        eventDrop: function(event, delta, revertFunc) {
            event.color = 'red';
            $('#calendar').fullCalendar('updateEvent', event);

            // TODO call revertFunc if ajax fails
        },
        eventResize: function(event, delta, revertFunc) {
            event.color = 'blue';
            $('#calendar').fullCalendar('updateEvent', event);

            // TODO call revertFunc if ajax fails
        },
        eventRender: function(event, element, view) {
            if (event.hasOwnProperty('lesson_id')) {
                var el = element.html();
                element.html("<b>" + event.title + "</b><br>" + event.groups.join(", "));
            }
        }
    });
});

var modal = $("#modal-lesson-create");

modal.on("hide.bs.modal", function(e) {
    $('#calendar').fullCalendar('removeEvents', 'new');
});


modal.on("click",".js-modal-save", function(){
    $.ajax({
        url: createUrl,
        type: 'POST',
        data: {
            teacher_course_id: $('#teacher_course_id').val(),
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
        }
    }).done(function (data) {
        modal.modal('toggle');
        $('#calendar').fullCalendar('refetchEvents');
    })
});

modal.on("click",".js-modal-cancel", function(){
    // code
});