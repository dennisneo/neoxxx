
var aVue = new Vue({
    el:'#aDiv',
    data:{
        applicant:[]
    },
    methods:{
        updateStatus:function(){
            $('#aModal').modal()
        },
        saveStatus:function(){

            $.post( subdir+'/ajax/admin/a/us' , $('#aForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success( 'User status updated' );
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