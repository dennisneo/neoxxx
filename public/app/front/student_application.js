var sVue = new Vue({
    el:'#sDiv',
    data:{

    },
    methods:{
        submit:function(){
            $('.btn').prop('disabled', true );
            $('#submit').html('<i class="fa fa-spin fa-refresh"></i>');

            $.post(subdir+'/ajax/front/sns' , $('#sForm').serialize() )
                .done(function( data ){
                    if(data.success){
                       window.location.href=subdir+'/s/application/success?ccid='+data.student.ccid
                    }else{
                       toastr.error( data.message );
                    }
                    $('.btn').prop('disabled', false );
                    $('#submit').html(' Submit ');

                })
                .error(function( data ){
                    toastr.error( 'Something went wrong' );
                });
        }

    },
    ready:function(){

    }
});
