
var peVue = new Vue({
    el:'#peDiv',
    ready:function(){
        $.get( subdir+'/ajax/admin/pe/get' )
        .done(function( data ){
            if(data.success){
               toastr.success('');
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    },
    data:{
        questions:[],
        question:{}
    },
    methods:{

    }
});