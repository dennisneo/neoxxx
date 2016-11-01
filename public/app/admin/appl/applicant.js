
var aVue = new Vue({
    el:'#aDiv',
    data:{
        applicant:[]
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
        }
    },
    ready:function(){

    }
});

$(document).ready(function(){
    $('.req').bootstrapToggle({
        on: ' <i class="fa fa-check"></i>',
        off: ' X ',
        size: 'mini'
    });
});

$('.tab').click(function(){
    $('.tab').removeClass('active');
    $('.tabDiv').addClass('hide');
    $(this).addClass( 'active');

    var d = $(this).attr('data-tab');
    $( '#'+d).removeClass('hide');

});