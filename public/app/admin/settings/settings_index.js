
var sVue = new Vue({
    el:'#sDiv',
    data:{

    },
    methods:{
        save:function(){
            $('.btn').prop('disabled', true );
            $('.save').html('<i class="fa fa-refresh fa-spin"></i>');
            $.post( subdir+'/ajax/admin/settings/s' , $('#sForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success('Settings successfully saved');
                }else{
                   toastr.error( data.message );
                }
                    $('.btn').prop('disabled', false );
                    $('.save').html('Save');
            })
            .error(function( data ){
                toastr.error( 'Something went wrong' );
                $('.btn').prop('disabled', false );
                $('.save').html('Save');
            });
        }
    },
    ready:function(){

    }
});

$(document).ready(function(){

});