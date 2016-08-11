
var peVue = new Vue({
    el:'#peDiv',
    ready:function(){
        $.get( subdir+'/ajax/admin/pe/get' )
        .done(function( data ){
            if( data.success ){
                peVue.$data.questions = data.questions
                peVue.$data.choices = data.choices
            }else{
               toastr.error( data.message );
            }
            $('.loading').addClass( 'hide' )
        })
        .error(function( data ){

        });
    },
    data:{
        questions:[],
        choices:[],
        question:{}
    },
    methods:{

    }
});