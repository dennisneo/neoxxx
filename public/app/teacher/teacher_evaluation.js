
var eVue = new Vue({
    el:'#eDiv',
    data:{
       feedbacks:[]
    },
    methods:{

    },
    ready:function(){
        $.get(subdir+'/ajax/teacher/feedbacks' , {teacher_id:$('#teacher_id').val()})
        .done(function( data ){
            if(data.success){
               eVue.$data.feedbacks = data.feedbacks
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){
            toastr.error('Something went wrong');
        });
    }
});

$( document ).ready(
    function(){

    });
