var csVue = new Vue({
    el:'#csDiv',
    data:{
        sessions:[],
        upcoming_sessions:[],
        upcoming_session:{}
    },
    methods:{
        cancelClass( row )
        {
            if( ! confirm( 'Are you sure you want to cancel this class? Credits may be charged during cancelation ')){
                return;
            }
            var vm = this;
            $.get(subdir+'/ajax/student/cc/'+row.class_id )
                .done(function( data ){
                    if(data.success){
                        toastr.success( 'Successfully cancelled the class' );
                        for( i=0; i < vm.$data.sessions.length; i++ ){
                            d = vm.sessions[i];
                            if( data.class.class_id == d.class_id ){
                                vm.$data.sessions.$set( i, data.class );
                            }
                        }
                    }else{
                        toastr.error( data.message );
                    }
                })
                .error(function( data ){
                    toastr.error('Something went wrong');
                });
        },
        showCancelButton( row )
        {

            if( row.class_status == 'Active' || row.class_status == 'For Confirmation'){
                return true;
            }

            return false;
        },
        showConfirmButton( row )
        {
            if( row.class_status == 'For Confirmation'){
                return true;
            }
            return false;
        },
        openStudentScheduleModal()
        {
            var vm = this;
            window.setTimeout(function() {
                if (!$("tr.fc-week").is(':visible')) {
                    $('.fc-today-button').click();
                    vm.loadCalendarEvents();
                }
            }, 500);
            $('#schedModal').modal();
        },
        loadCalendarEvents:function(){

            var vm = this;
            $('#sched_calendar').fullCalendar( 'removeEvents');

            $.get(subdir+'/ajax/student/gms')
                .done(function( data ){
                    if( data.success ){
                        vm.upcoming_sessions = [];
                        for( i = 0 ; i < data.sessions.length ; i++ ){
                            s = data.sessions[i];

                            start_timestamp = parseInt( s.start_timestamp ) * 1000;
                            end_timestamp   = parseInt( s.end_timestamp ) * 1000;

                            event = { id: s.class_id , title: ' ', editable : false,  bookable:true,
                                start:  new Date( start_timestamp ).toISOString() , end: new Date( end_timestamp ).toISOString() };

                            $('#sched_calendar').fullCalendar( 'renderEvent', event, true);
                            vm.upcoming_sessions.push( s );
                        }

                    }else{
                        toastr.error( data.message );
                    }
                })
                .error(function( data ){

                });
        }
    },
    ready:function(){
        var vm = this;
        $.get( subdir+'/ajax/student/ics', {sid: $('#student_id').val()} )
            .done(function( data ){
                if(data.success){
                    vm.sessions = data.s;
                }else{
                    toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
    }
});

$(document).ready(function(){
    $('#sched_calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: $('#date_today').val(),
        defaultView: 'agendaWeek',
        editable: true,
        minTime:"06:00:00",
        events: [],
        eventClick: function( calEvent, jsEvent, view) {
            $('#eventModal').modal();

            for( i=0; i < csVue.upcoming_sessions.length; i++ ){
                d = csVue.upcoming_sessions[i];
                if( d.class_id == calEvent.id ){
                    csVue.upcoming_session = d;
                }
            }


        }
    });
});