
var aVue = new Vue({
    el:'#aDiv',
    data:{
        applicant:[],
        notes: []
    },
    methods:{
        updateStatus:function(){
            $('#aModal').modal()
        },
        saveRequirements:function()
        {
            $('.btn').prop('disabled', true );
            $('#rqBtn').html( '<i class="fa fa-spin fa-refresh"></i>');
            $.post( subdir+'/ajax/admin/a/srq' , $('#rForm').serialize() )
                .done(function( data ){
                    if(data.success){
                        toastr.success( 'Requirements successfully updated' );
                    }else{
                        toastr.error( data.message );
                    }
                    $('.btn').prop('disabled', false );
                    $('#rqBtn').html( 'Save Requirements');
                })
                .error(function( data ){
                    toastr.error( 'Somthing went wrong' );
                });
        },
        saveStatus:function(){

            $.post( subdir+'/ajax/admin/a/us' , $('#aForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success( 'User status updated' );
                   $('#aModal').modal( 'toggle' );
                   if(data.user_type == 'teacher'){
                       location.href=subdir+'/admin/teacher/schedule/'+$('#user_id').val();
                   }
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },
        saveNote:function()
        {
            $('.btn').prop('disabled', true );
            $.post(subdir+'/ajax/note/save' , $('#nForm').serialize())
            .done(function( data ){
                if(data.success){
                    toastr.success( 'Note successfully saved' );
                    aVue.$data.notes.push( data.note );
                    $('#note').val('');
                }else{
                   toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
            })
            .error(function( data ){
                toastr.error('Something went wrong');
                $('.btn').prop('disabled', false );
            });
        }
    },
    ready:function(){
        $('#note').val('');
        $.get( subdir+'/ajax/notes/get' , {aid:$('#note_to').val()} )
        .done(function( data ){
            if(data.success){
                aVue.$data.notes = data.notes;
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){
            toastr.error('Something went wrong');
        });

        $.get( subdir+'/ajax/req/get' , { aid: $('#applicant_id').val() })
        .done(function( data ){
            if( data.success ){
                $( '#valid_credentials').prop( 'checked' , parseInt( data.req.valid_credentials ) );
                $( '#fast_internet').prop( 'checked' , parseInt( data.req.fast_internet ) );
                $( '#comfortable_home_office').prop( 'checked' , parseInt( data.req.comfortable_home_office ) );
                $( '#audio_recording').prop( 'checked' , parseInt( data.req.audio_recording ) );
                $( '#appropriate_schedule').prop( 'checked' , parseInt( data.req.appropriate_schedule ) );
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
    /**
    $('.req').bootstrapToggle({
        on: ' <i class="fa fa-check"></i>',
        off: ' X ',
        size: 'mini'
    });
     ***/
});

$('.tab').click(function(){
    $('.tab').removeClass('active');
    $('.tabDiv').addClass('hide');
    $(this).addClass( 'active');

    var d = $(this).attr('data-tab');
    $( '#'+d).removeClass('hide');

});