
var tVue = new Vue({
    el:'#tDiv',
    data:{
        sessions:[],
        session:{}
    },
    methods:{
        showAudioDiv:function( src )
        {
            if( src == false ){
                $('#hasNoAudio').removeClass( 'hide' );
                $('#hasAudio').addClass( 'hide' );
                $('#audio_control').attr('src' , '' );
            }else{
                $('#hasAudio').removeClass( 'hide' );
                $('#hasNoAudio').addClass( 'hide' );
                $('#audio_control').attr('src' , src );
            }
        },
        openClassRecord:function( cid ){
            $.get(subdir+'/ajax/teacher/gcr' , { cid:cid } )
            .done(function( data ){
                if(data.success){
                    tVue.$data.session = data.session;
                    $('#class_id').val( data.session.class_id );
                    $('#performance_notes').val( data.session.performance_notes );
                    $('#comments').val( data.session.comments );
                    $('#actual_duration').val( data.session.actual_duration );
                    $('#class_status').val( data.session.class_status );

                    if( data.session.audio_file ){
                        tVue.showAudioDiv( data.session.audio_file  );
                    }else{
                        $('#hasNoAudio').removeClass( 'hide' );
                        $('#hasAudio').addClass( 'hide' );
                    }
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                    toastr.error( 'Something went wrong!' );
            });
            $('#classRecordModal').modal();
        },
        saveClassRecord:function(){
            $.post( subdir+'/ajax/teacher/ucr', $('#sForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success( 'Class record successfully updated' );
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },
        deleteAudio:function()
        {
            ccid = $('#ccid').val();

            if( ! confirm( 'Are you sure you want to delete audio file? ')){
                return;
            }
            $.post(subdir+'/ajax/teacher/daf' , { ccid:ccid , _token : $('input[name=_token]').val()})
            .done(function( data ){
                if(data.success){
                    tVue.showAudioDiv( false );
                   toastr.success('Audio file successfully deleted');
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },
        openNotificationModal:function(){
            $('#notificationModal').modal();
        },
        openStudentInfoModal:function(){
            $('#studentInfoModal').modal();
        },
        sendNotification:function()
        {

        },
        sendForm:function()
        {

        },
        search:function(){
            this.getClasses();
        },
        getClasses:function()
        {
            this.sessions =  [];
            $('.loading').html( '<i class="fa fa-refresh fa-spin"></i>' );

            $.get( subdir+'/ajax/teacher/gts' , $('#searchForm').serialize())
                .done(function( data ){
                    if(data.success){
                        tVue.$data.sessions =  data.sessions;
                        $('.loading').html( 'No record found' );
                    }else{
                        toastr.error( data.message );
                    }
                }).error(function( data ){
                    toastr.error( ' Something went wrong ! ')
                });
        }

    },
    ready:function(){
        this.getClasses();
    }
});

$( document ).ready(
    function(){
        $( '#fileupload' ).fileupload({
            dataType: 'json',
            progress: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.bar').css('width', progress + '%');
            },
            done: function (e, data) {
                $('.bar').css('width', '0%');
                if( data.result.success){
                    toastr.success('Audio file successfully uploaded');
                    tVue.showAudioDiv( data.result.session.audio_file );
                }else{
                    toastr.error( data.result.message )
                }
            }
        });

        $('#date_from').datepicker();
        $('#date_to').datepicker();
    });
