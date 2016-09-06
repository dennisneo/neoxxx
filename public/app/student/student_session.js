
var sVue = new Vue({
    el:'#sDiv',
    data:{
        teachers:[],
        selected_teacher:{}
    },
    methods:{
        teacherSelected:function( tid ){
            $.post( subdir+'/ajax/student/ts' , { cid: $('#cid').val() , tid:tid ,_token:$('#_token').val() })
            .done(function( data ){
                if( data.success ){
                    sVue.$data.selected_teacher = data.teacher
                    toastr.success( 'Teacher selected' );
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },
        saveSession:function(){
            $('.btn').prop('disabled', true );
            $('.save').html('<i class="fa fa-refresh fa-spin"></i>' );

            if( ! this.selected_teacher.id ){

                $('.btn').prop('disabled', false );
                $('.save').html( '<i class="fa fa-check"></i> Confirm' );
                toastr.error( 'You need to select a teacher before you can procceed' );
                return;

            }

            $.post(  subdir+'/ajax/student/sas' , $('#sForm').serialize() )
            .done(function( data ){
                   if(data.success){
                       url = subdir+'/student/sdetails?cid='+data.cid;
                       window.location.href  = url;
                   }else{
                       $('.btn').prop('disabled', false );
                       $('.save').html( '<i class="fa fa-check"></i> Confirm' );
                      toastr.error( data.message );
                   }
            })
            .error(function( data ){
                    $('.btn').prop('disabled', false );
                    $('.save').html( '<i class="fa fa-check"></i> Confirm' );
                    toastr.error( 'Something went wrong' );
            });
        },
        cancelSession:function()
        {
            if( confirm( 'Are you sure you want to cancel this class session?') ){
                $.post( subdir+'/ajax/student/sas' , $('#sForm').serialize() )
                .done(function( data ){

                })
                .error(function( data ){

                });
            }
        }
    },
    ready:function(){
        // load available teachers
        $.get( subdir+'/ajax/student/at' , { cid: $('#cid').val() } )
        .done(function( data ){
            if( data.success ){
                if(data.success){
                    sVue.$data.teachers = data.teachers
                }else{
                   toastr.error( data.message );
                }
                $('.loading').addClass('hide')
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});


