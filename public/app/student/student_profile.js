
var sVue = new Vue({
    el:'#sDiv',
    data:{
    
    },
    methods:{
        openAboutModal:function(){
            $('#aboutModal').modal();
        },
        openProfileModal:function() {
            $('#profileModal').modal();
        },
        saveProfile:function(){

            $('.btn').prop('disabled', true );
            $('#spButton').html('<i class="fa fa-spin fa-refresh"></i>');

            $.post(subdir+'/ajax/student/sp' , $('#pForm').serialize())
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

            $.post(subdir+'/ajax/student/uab' , $('#aForm').serialize())
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
        }
    },
    ready:function(){
    
    }
});


$(document).ready(function(){
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
        },
        error: function(){
            toastr.error('Something went wrong!')
        }
    });
});