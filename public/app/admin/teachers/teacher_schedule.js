var tsVue = new Vue({
    el:'#tsDiv',
    data:{

    },
    methods:{
        openNewSched:function()
        {
            // clean all fields
            $('#schedModal').modal();
        },

        saveSched:function()
        {
            var event;
            $('.btn').prop('disabled', true );
            $.post(subdir+'/ajax/admin/teacher/add_schedule' , $('#tForm').serialize() )
            .done(function( data ){
                if(data.success){
                    toastr.success( ' Schedule added ');
                    $('#schedModal').modal( 'toggle' );

                    if( data.error_messages ){
                        toastr.warning( data.error_messages);
                    }

                    for( i = 0 ; i < data.schedules.length ; i++ ){
                        s = data.schedules[i];
                        event = { id: s.sid , title:' Vacant ', start:  new Date( s.start_timestamp ).toISOString() , end: new Date( s.end_timestamp ).toISOString() };
                        $('#calendar').fullCalendar( 'renderEvent', event, true);
                    }

                }else{
                   toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
            })
            .error(function( data ){
                $('.btn').prop('disabled', false );
            });
        }
    },
    ready:function(){

        $.get(subdir+'/ajax/admin/teacher/get_schedule' , {tid:$('#teacher_id').val() })
        .done(function( data ){
            if(data.success){
                for( i = 0 ; i < data.schedules.length ; i++ ){
                    s = data.schedules[i];

                    start_timestamp = parseInt( s.start_timestamp ) * 1000;
                    end_timestamp = parseInt( s.end_timestamp ) * 1000;

                    event = { id: s.sid , title:'  ',editable : false,
                        start:  new Date( start_timestamp ).toISOString() , end: new Date( end_timestamp ).toISOString() };
                    $('#calendar').fullCalendar( 'renderEvent', event, true);

                    start_timestamp = parseInt( s.nw_start_timestamp ) * 1000;
                    end_timestamp   = parseInt( s.nw_end_timestamp ) * 1000;
                    sid = start_timestamp;

                    event = { id: sid, title:'  ', editable : false,
                         start:  new Date( start_timestamp ).toISOString() , end: new Date( end_timestamp ).toISOString() };
                    $('#calendar').fullCalendar( 'renderEvent', event, true);
                }

                for( i = 0 ; i < data.classes.length ; i++ ){
                    c = data.classes[i];
                    start_timestamp = parseInt( c.start_timestamp ) * 1000;
                    end_timestamp = parseInt( c.end_timestamp ) * 1000;
                    title = c.s_fname+' '+ c.s_lname;
                    event = { id: c.class_id , title: title, color:'red', editable : false,
                        start:  new Date( start_timestamp ).toISOString() , end: new Date( end_timestamp ).toISOString() };
                    $('#calendar').fullCalendar( 'renderEvent', event, true);
                }
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
            $('#eventModal').modal();
        }
    });

    $('#start_time').combodate(
        {
            customClass: 'date-control'
        }
    );

    $('#end_time').combodate(
        {
            customClass: 'date-control'
        }
    );



});
