var modal = $("#modal-lesson-create");
var modalForm = $('#modal-form');
var loader = $('.js-loader');

$(document).ready(function () {

    $('#calendar').fullCalendar({
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
        selectable: true,
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
            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true

            modalForm.yiiActiveForm('resetForm');
            modal.modal({backdrop: 'static', keyboard: false});
            modal.find('#start').val(start.format('YYYY-MM-DD HH:mm:ss'));
            modal.find('#end').val(end.format('YYYY-MM-DD HH:mm:ss'));
            modal.find('#teacher_course_id').val(null).trigger("change");
            modal.find('#teacher_id').val(null).trigger("change");
            modal.find('#classroom_id').val(null).trigger("change");

            // }
            // $('#calendar').fullCalendar('unselect');
        },
        editable: true,
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
            modal.find('#group_id').val(event.group_id);
            modal.find('#classroom_id').val(event.classroom_id).trigger("change");
        },
        eventDrop: function (event, delta, revertFunc) {
            event.color = 'red';
            event.unsaved = true;
            $('#calendar').fullCalendar('updateEvent', event);

            // TODO call revertFunc if ajax fails
        },
        eventResize: function (event, delta, revertFunc) {
            event.color = 'red';
            event.unsaved = true;
            $('#calendar').fullCalendar('updateEvent', event);

            // TODO call revertFunc if ajax fails
        },
        eventRender: function (event, element, view) {
            if (event.hasOwnProperty('groups')) {
                element.find('.fc-title').append("<br/>" + "<small>" + event.groups.join(", ") + "</small>");
            }
        }
    });
});



// On hide modal remove select (temporary event)
modal.on("hide.bs.modal", function (e) {
    $('#calendar').fullCalendar('removeEvents', 'new');
});

// Clicked Save
modal.on("click", ".js-modal-save", function () {
    modalForm.submit();
});

// Clicked Copy
modal.on("click", ".js-modal-copy", function () {
    window.location.replace("copy?lesson_id=" + $('#id').val());
});


// Clicked Cancel
modal.on("click", ".js-modal-cancel", function () {

});

// Clicked Delete
modal.on("click", ".js-modal-delete", function() {
    if (confirm("Do you want to remove this lesson?")) {
        loadingEnabled();
        $.ajax({
            url: deleteUrl,
            type: 'POST',
            data: {
                id: $('#id').val(),
            }
        }).done(function (data) {
            modal.modal('toggle');
            $('#calendar').fullCalendar('refetchEvents');
        }).always(function () {
            loadingDisabled();
        });
    }
});

// Prevent form submit, send ajax request
modalForm.on('beforeSubmit', function (e) {
    loadingEnabled();
    $.ajax({
        url: createUrl,
        type: 'POST',
        data: {
            id: $('#id').val(),
            teacher_course_id: $('#teacher_course_id').val(),
            teacher_id: $('#teacher_id').val(),
            start: $('#start').val(),
            end: $('#end').val(),
            group_id: $('#group_id').val(),
            classroom_id: $('#classroom_id').val(),
        }
    }).done(function (data) {
        modal.modal('toggle');
        $('#calendar').fullCalendar('refetchEvents');
    }).always(function () {
        loadingDisabled();
    });
    return false;
});

function loadingEnabled() {
    loader.addClass('loader--loading');
}

function loadingDisabled() {
    loader.removeClass('loader--loading');
}