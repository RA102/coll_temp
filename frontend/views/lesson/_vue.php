<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.7.1/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.22/vue.min.js"></script>

<script>
    Vue.component('calendar', {
        template: '<div></div>',

        props: {
            events: {
                type: Array,
                required: true
            },

            editable: {
                type: Boolean,
                required: false,
                default: false
            },

            droppable: {
                type: Boolean,
                required: false,
                default: false
            },
        },

        data: function()
        {
            return {
                cal: null
            }
        },

        ready: function()
        {
            var self = this;
            self.cal = $(self.$el);


            var args = {
                lang: 'de',
                header: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'month,agendaWeek,agendaDay'
                },
                height: "auto",
                allDaySlot: false,
                slotEventOverlap: false,
                timeFormat: 'HH:mm',

                events: self.events,

                dayClick: function(date)
                {
                    self.$dispatch('day::clicked', date);
                    self.cal.fullCalendar('gotoDate', date.start);
                    self.cal.fullCalendar('changeView', 'agendaDay');
                },

                eventClick: function(event)
                {
                    self.$dispatch('event::clicked', event);
                    event.title = 'Clicked!';
                    self.cal.fullCalendar('updateEvent', event);
                }
            }

            if (self.editable)
            {
                args.editable = true;
                args.eventResize = function(event)
                {
                    self.$dispatch('event::resized', event);
                }

                args.eventDrop = function(event)
                {
                    self.$dispatch('event::dropped', event);
                }
            }

            if (self.droppable)
            {
                args.droppable = true;
                args.eventReceive = function(event)
                {
                    self.$dispatch('event::received', event);
                }
            }

            this.cal.fullCalendar(args);

        }

    })

    new Vue({
        el: '#app',

        data: {
            events: [
                {
                    title: 'Event1',
                    start: '2019-02-21 12:30:00',
                    end: '2019-02-21 16:30:00'
                },
                {
                    title: 'Event2',
                    start: '2019-02-20 17:30:00',
                    end: '2019-02-20 21:30:00'
                }
            ]
        },

        events: {
            'day::clicked': function(date)
            {
                console.log(date);
            },
            'event::resized': function(event)
            {
                console.log(event);
            },
            'event::clicked': function(event)
            {
                console.log('clicked');
                event.start = '2019-02-20 18:30:00';
                event.end= '2019-02-20 19:30:00';
            }
        },

        methods: {
            run() {
                this.events = [
                    {
                        title: 'Event1',
                        start: '2019-02-22 12:30:00',
                        end: '2019-02-22 13:30:00'
                    },
                    {
                        title: 'Event2',
                        start: '2019-02-21 12:30:00',
                        end: '2019-02-21 23:30:00'
                    }
                ];
                alert("pressed");
            }
        }
    })
</script>