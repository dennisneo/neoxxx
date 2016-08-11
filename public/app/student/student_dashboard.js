
var sVue = new Vue({
    el:'#sDiv',
    data:{
    
    },
    methods:{
        showCalendar:function(){
            $( "#date" ).datepicker( 'show' );
        },
        scheduleSession:function(){

            $('.btn').prop('disabled', true );
            $('#next').html( '<i class="fa fa-refresh fa-spin"></i>' );
            $.post( subdir+'/ajax/student/ss' , $('#sForm').serialize())
            .done(function( data ){
                if(data.success){
                   url = subdir+'/student/newsession?sid='+data.sid;
                   window.location.href  = url;
                   return;
                }else{
                   toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
                $('#next').html( ' Next ' );
            })
            .error(function( data ){
                $('.btn').prop('disabled', false );
                $('#next').html( ' Next ' );
            });
        }
    },
    ready:function(){
        $( "#date" ).datepicker({});
    }
});


