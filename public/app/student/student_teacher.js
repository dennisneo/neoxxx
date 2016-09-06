var sVue = new Vue({
    el:'#sDiv',
    data:{
        teachers:[]
    },
    methods:{
    
    },
    ready:function(){
        $.get( subdir+'/ajax/students/getAvailableTeachers')
        .done(function( data ){
            if(data.success){
               sVue.$data.teachers =  data.teachers
            }else{
               toastr.error( data.message );
            }
        }).error(function( data ){

        });
    }
});
