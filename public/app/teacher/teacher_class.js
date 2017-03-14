var tVue = new Vue({
    el:'#tDiv',
    data:{
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
        openClassRecordModal( ){
            $.get(subdir+'/ajax/teacher/gcr' , { cid:$('#class_id').val() } )
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
            var vm = this
            $.post( subdir+'/ajax/teacher/ucr', $('#sForm').serialize() )
                .done(function( data ){
                    if(data.success){
                        r = vm.sessions;
                        for( i=0; i < r.length; i++ ){
                            d = r[i];
                            if(d.class_id == data.sessions.class_id){
                                tVue.$data.sessions.$set( i, data.sessions );
                            }
                        }
                        toastr.success( 'Class record successfully updated' );
                        $('#classRecordModal').modal( 'toggle' );
                    }else{
                        toastr.error( data.message );
                    }
                })
                .error(function( data ){

                });
        }
    },
    ready:function(){

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
    }
);