
var tVue  =  new Vue({
    el:'#tDiv',
    data:{
        classes: []
    },
    methods:{
        editProfile:function(){
            $('#profileModal').modal();
        }
    },
    ready:function(){

        $.get( subdir+'/ajax/teacher/upcoming' , { tid: $('#tid').val() } )
        .done(function( data ){
            if(data.success){
                tVue.$data.classes = data.classes
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){
            toastr.error('Something went wrong');
        });

    }
});

