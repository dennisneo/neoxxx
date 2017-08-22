
var aVue = new Vue({
    el:'#aDiv',
    data:{
        applicant:[],
        req:{},
        notes: [],
        spinner : '<i class="fa fa-spin fa-refresh"></i>',
        loading: false
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
        },
        deleteCV( applicant_id ){

            let vm = this;
            vm.loading = true;
            $.ajax({ url: subdir+'/ajax/cv', type: 'DELETE',dataType:'json',
                data:{ applicant_id : applicant_id , _token: $('input[name="_token"]').val() },
                success: function( data ){
                    vm.req  =   data.req;
                    toastr.success( 'CV successfully deleted' );
                    vm.loading = false;
                }
            }).fail(function() {
                toastr.error( 'Something went wrong' );
                vm.loading = false;
            })
        }
    },
    ready:function(){
        let vm  = this;
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

                vm.req = data.req;
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

    $( '#cv' ).fileupload({
        dataType: 'json',
        progress: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.bar').css('width', progress + '%');
        },
        done: function (e, data) {
            $('.bar').css('width', '0%');
            if( data.result.success){
                toastr.success( 'Resume successfully uploaded' );
                aVue.req = data.result.req;
            }else{
                toastr.error( data.result.message )
            }
        }
    });
});

$('.tab').click(function(){
    $('.tab').removeClass('active');
    $('.tabDiv').addClass('hide');
    $(this).addClass( 'active');

    var d = $(this).attr('data-tab');
    $( '#'+d).removeClass('hide');

});