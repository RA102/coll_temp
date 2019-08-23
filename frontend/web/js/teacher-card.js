$(document).ready(function () {

    $('#teacher-calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        locale: 'ru',
        defaultView: 'agendaWeek',
        firstDay: 1,
        defaultDate: moment().format('YYYYMMDD'),
        navLinks: true, // can click day/week names to navigate views
        selectable: false,
        selectHelper: true,
        slotLabelFormat: 'HH:mm',
        slotLabelInterval: '01:00',
        slotDuration: '01:00',
        minTime: '07:00',
        maxTime: '23:00',
        timeFormat: 'HH:mm',
        select: function (start, end) {
            eventData = {
                id: 'new',
                title: '',
                start: start,
                end: end,
            };
            $('#teacher-calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

            modalForm.yiiActiveForm('resetForm');
            modal.modal({backdrop: 'static', keyboard: false});
            modal.find('#start').val(start.format('YYYY-MM-DD HH:mm:ss'));
            modal.find('#end').val(end.format('YYYY-MM-DD HH:mm:ss'));
            modal.find('#teacher_course_id').val(null).trigger("change");
            modal.find('#teacher_id').val(null).trigger("change");

            // }
            // $('#teacher-calendar').fullCalendar('unselect');
        },
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        eventSources: [

            // your event source
            {
                url: feedUrl, // use the `url` property
                color: '#1be44f',    // an option!
                textColor: 'black'  // an option!
            }
        ],
        events: [],
        eventClick: function (event) {
            modalForm.yiiActiveForm('resetForm');
            modal.modal({backdrop: 'static', keyboard: false});
            modal.find('#start').val(event.start.format('YYYY-MM-DD HH:mm:ss'));
            modal.find('#end').val(event.end.format('YYYY-MM-DD HH:mm:ss'));
            modal.find('#teacher_course_id').val(event.teacher_course_id).trigger("change");
            modal.find('#teacher_id').val(event.teacher_id).trigger("change");
            modal.find('#id').val(event.id);
        },
        eventDrop: function (event, delta, revertFunc) {
            event.color = 'red';
            event.unsaved = true;
            $('#teacher-calendar').fullCalendar('updateEvent', event);

            // TODO call revertFunc if ajax fails
        },
        eventResize: function (event, delta, revertFunc) {
            event.color = 'red';
            event.unsaved = true;
            $('#teacher-calendar').fullCalendar('updateEvent', event);

            // TODO call revertFunc if ajax fails
        },
        eventRender: function (event, element, view) {
            if (event.hasOwnProperty('groups')) {
                element.find('.fc-title').append("<br/>" + "<small>" + event.groups.join(", ") + "</small>");
            }
        }
    });
});



