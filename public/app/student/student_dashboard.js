
var sVue = new Vue({
    el:'#sDiv',
    data:{
        credits: 0
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
                   url = subdir+'/student/newsession?cid='+data.cid;
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
        },
        bookClass:function()
        {
            bcVue.$data.teacher = {};
            $('#bookClassModal').modal();
        }
    },
    ready:function(){
        $.get( subdir+'/ajax/student/credits' , { sid: $('#student_id').val()} )
        .done(function( data ){
            if(data.success){
                sVue.$data.credits = data.credits
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){
                toastr.error( 'Something went wrong' );
        });
    }
});



