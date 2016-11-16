var bVue = new Vue({
    el:'#bDiv',
    data:{
        credits_cost: []
    },
    methods:{
        buy:function( cost_id , t ){
            $(t).html( '<i class="fa fa-spin fa-refresh"></i>');
            $('#cost_id').val( cost_id );
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
        $.get(subdir+'/ajax/student/settings/credits_cost')
            .done(function( data ){
                if( data.success ){
                    bVue.$data.credits_cost = data.credits_cost;
                }else{
                    toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
    }
});
