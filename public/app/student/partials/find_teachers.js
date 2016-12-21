var ftVue = new Vue({
    el:'#ftDiv',
    data:{
        teachers: [],
        teacher:{},
        time_select:[]
    },
    methods:{
        search:function(){

            $.get( subdir+'/ajax/student/teacher/search' , { q:$('#q').val() })
            .done(function( data ){
                if(data.success){
                   ftVue.$data.teachers = data.teachers
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });

        },

        loadCalendarEvents:function( tid ){

            $('#calendar').fullCalendar( 'removeEvents');
            $.get(subdir+'/ajax/admin/teacher/get_schedule' , { tid:tid })
                .done(function( data ){
                    if( data.success ){
                        for( i = 0 ; i < data.schedules.length ; i++ ){
                            s = data.schedules[i];

                            start_timestamp = parseInt( s.start_timestamp ) * 1000;
                            end_timestamp   = parseInt( s.end_timestamp ) * 1000;

                            event = { id: s.sid , title:'  ',editable : false,  bookable:true,
                                start:  new Date( start_timestamp ).toISOString() , end: new Date( end_timestamp ).toISOString() };

                            $('#calendar').fullCalendar( 'renderEvent', event, true);

                        }

                        for( i = 0 ; i < data.classes.length ; i++ ){
                            c = data.classes[i];
                            start_timestamp = parseInt( c.start_timestamp ) * 1000;
                            end_timestamp = parseInt( c.end_timestamp ) * 1000;
                            //title = c.s_fname+' '+ c.s_lname;
                            title=' ';
                            event = { id: c.class_id , title: title, color:'red', editable : false, bookable:false,
                                start:  new Date( start_timestamp ).toISOString() , end: new Date( end_timestamp ).toISOString() };
                            $('#calendar').fullCalendar( 'renderEvent', event, true);
                        }
                    }else{
                        toastr.error( data.message );
                    }
                })
                .error(function( data ){

                });
        },
        openAvailability:function( tid ){

            var d = ftVue.$data;
            var dt;

            for( var i = 0 ; i < d.teachers.length ; i++ ){
                dt = d.teachers[i];
                if( dt.cid == tid  ){
                    d.teacher = dt;
                    break;
                }
            }

            window.setTimeout(function() {
                if (!$("tr.fc-week").is(':visible')) {
                    $('.fc-today-button').click();
                    ftVue.loadCalendarEvents( tid );
                }
            }, 200);

            $('#availabilityModal').modal();

        },
        openProfile:function( tid ){

            var d = ftVue.$data;
            var dt;

            for( var i = 0 ; i < d.teachers.length ; i++ ){
                dt = d.teachers[i];
                if( dt.cid == tid  ){
                    d.teacher = dt;
                    break;
                }
            }
            $('#profileModal').modal()
        },
        bookTeacher:function( tid ) {
            $('#profileModal').modal('toggle');
            $('#bookClassModal').modal();
            bcVue.$data.teacher = this.teacher
        },
        confirmBooking:function()
        {
            var dt = $('#start_time').val();
            var du = $('#duration').val() * 60;

            for( i=0; i < ftVue.$data.time_select.length; i++ ){
                d = ftVue.$data.time_select[i];
                if( dt == d.dt ){
                    if( du > d.max){
                        toastr.error( 'Duration exceeds teacher schedule. Please choose a lower class duration' );
                        return;
                    }
                }
            }

            $.post( subdir+'/ajax/student/sas' , $('#bForm').serialize() )
            .done(function( data ){
                if(data.success){
                   location.href= subdir+'/student/sdetails?cid='+data.cid;
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });

        },
        r:function( n ){
            return parseInt( Math.round(n) );
        }
    },
    ready:function(){
        $.get( subdir+'/ajax/teachers/getall' )
        .done(function( data ){
            d  = ftVue.$data.teachers;
            if(data.success){
                ftVue.$data.teachers = data.teachers
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});


$(document).ready(function() {

    $('.btn').prop('disabled', false );

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: $('#date_today').val(),
        defaultView: 'agendaWeek',
        editable: true,
        minTime:"06:00:00",
        events: [

        ],
        eventClick: function( calEvent, jsEvent, view) {

            if( calEvent.bookable ){
                var s = calEvent.start.format('YYYY/MM/DD HH:mm:ss');
                var e = calEvent.end.format('YYYY/MM/DD HH:mm:ss');

                $('#booking_date').val( calEvent.start.format('YYYY-MM-DD') );
                $('#teacher_id').val( ftVue.$data.teacher.id );

                $('#class_date').html( calEvent.start.format('MMM DD, YYYY ddd') );
                $('#teacher_name').html( ftVue.$data.teacher.short_name );

                $('#bookingModal').modal();

                $.get( subdir+'/ajax/util/ts' , {s:s, e:e})
                .done(function( data ){
                    if(data.success){
                        ftVue.$data.time_select = data.s;
                    }else{
                       toastr.error( data.message );
                    }
                })
                .error(function( data ){
                    toastr.error('Something went wrong');
                });

            }

        }
    });

});

