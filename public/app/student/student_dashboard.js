
var sVue = new Vue({
    el:'#sDiv',
    data:{
        credits: 0,
        sessions: []
    },
    methods:{
        sendConfirmationEmail:function(){
            $.blockUI( { message: '<h3>Sending email... Please wait</h3>' });

            $.get( subdir+'/ajax/student/sce' )
            .done(function( data ){
                if(data.success){
                    if(data.success){
                       toastr.success('Email sent. Please check your inbox for the confirmation link');
                    }else{
                       toastr.error( data.message );
                    }

                }else{
                    toastr.error( data.message );
                }
                $.unblockUI();
            }).error(function( data ){
                toastr.error('Something went wrong');
                $.unblockUI();
            });
        },
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
            // check first if user is has confirmed his email
            $.get( subdir+'/ajax/student/ce' )
            .done(function( data ){
                if(data.success){
                    if( data.confirmed ){
                        bcVue.$data.teacher = {};
                        $('#bookClassModal').modal();
                    }else{
                        toastr.error( 'You need to validate your email before you can book a class' );
                    }
                }else{
                   toastr.error( data.message );
                }
            }).error(function( data ){
                toastr.error('Something went wrong');
            });

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



