var tpVue = new Vue({
    el:'#tpDiv',
    data:{
    
    },
    methods:{
        openAudioInfo(){
            $('#audioInfoModal').modal();
            setTimeout( function(){
                $('#audioInfoModal').modal( 'toggle' );
            }, 6000 );
        },
        openImageInfo(){
            $('#imageInfoModal').modal();
            setTimeout( function(){
                $('#imageInfoModal').modal( 'toggle' );
            }, 6000 );
        },
        openAboutModal:function(){
            $('#aboutModal').modal();
        },
        editProfile:function() {
            $('#profileModal').modal();
        },
        uploadPhoto:function(){
            $('#photoModal').modal();
        },
        uploadVoice:function(){

        },
        saveProfile:function(){
            $('.btn').prop('disabled', true );
            $('#spButton').html('<i class="fa fa-spin fa-refresh"></i>');
            $.post(subdir+'/ajax/teacher/sp' , $('#pForm').serialize())
            .done(function( data ){
                    if(data.success){
                       toastr.success( 'Profile successfully saved' );
                       $('#profileModal').modal( 'toggle' );
                       location.reload();
                    }else{
                       toastr.error( data.message );
                    }
                $('.btn').prop('disabled', false );
                $('#spButton').html('Save');
            })
            .error(function( data ){
                toastr.error( 'Something went wrong' );
                $('.btn').prop('disabled', false );
                $('#spButton').html('Save');
            });
        },
        saveAbout:function(){
            $('.btn').prop('disabled', true );
            $('#abButton').html('<i class="fa fa-spin fa-refresh"></i>');

            $.post(subdir+'/ajax/teacher/uab' , $('#aForm').serialize())
                .done(function( data ){
                    if(data.success){
                        toastr.success( 'Write up successfully updated' );
                        $('#aboutModal').modal( 'toggle' );
                        $('#about').html( data.about )
                    }else{
                        toastr.error( data.message );
                    }
                    $('.btn').prop('disabled', false );
                    $('#abButton').html('Save');
                })
                .error(function( data ){
                    toastr.error( 'Something went wrong' );
                    $('.btn').prop('disabled', false );
                    $('#abButton').html('Save');
                });
        },
        deleteAudio:function(cid ){
            if( !confirm( 'Are you sure you want to delete audio file?') ){
                return
            }
            $.post( subdir+'/ajax/teacher/dv' , { cid:cid , _token:$('input[name="_token"]').val() } )
            .done(function( data ){
                if(data.success){
                    $('.udiv').addClass( 'hide' );
                    $('#audio_control').prop('src', '' );
                    toastr.success( '' );
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                    toastr.error( 'Something went wrong' );
            });
        }

    },
    ready:function(){
    
    }
});

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $('#date1').combodate({
        minYear: 1950,
        maxYear: 2016,
        minuteStep: 10,
        customClass : 'date-control'
    });

    $( '#fileupload' ).fileupload({
        dataType: 'json',
        progress: function (e, data) {
            var progress = parseInt( data.loaded / data.total * 100, 10);
            $('.bar').css('width', progress + '%');
        },
        done: function (e, data) {
            $('.bar').css('width', '0%');
            if( data.result.success){
                toastr.success('Profile photo successfully uploaded');
                $('#photo_src').prop( 'src' , data.result.user.profile_photo_url );
            }else{
                toastr.error( data.result.message )
            }
        }
    });

    $( '#voiceupload' ).fileupload({
        dataType: 'json',
        progress: function (e, data) {
            var progress = parseInt( data.loaded / data.total * 100, 10);
            $('.abar').css('width', progress + '%');
        },
        done: function (e, data) {
            $('.abar').css('width', '0%');
            if( data.result.success){
                $('.udiv').removeClass( 'hide' );
                $('#audio_control').prop('src', data.result.url );
                toastr.success('Audio file successfully uploaded');
            }else{
                toastr.error( data.result.message )
            }
        }
    });

});