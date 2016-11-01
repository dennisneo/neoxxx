var bVue = new Vue({
    el:'#bDiv',
    data:{

    },
    methods:{
        buy:function( credits , t ){
            $(t).html( '<i class="fa fa-spin fa-refresh"></i>');
            $('#credits').val( credits );

            $.post( subdir+'/ajax/student/bc', $('#cForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success( 'Credits successfully added. Your total credits is now '+data.credit.credits );
                   setTimeout( function(){
                        location.href =subdir+'/student/dashboard'
                   }, 3000 );
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
