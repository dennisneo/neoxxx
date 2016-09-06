
var tVue = new Vue({
    el:'#tDiv',
    data:{
        teachers:[]
    },
    methods:{

    },
    ready:function(){
        $.get(  subdir+'/ajax/teachers/getall')
        .done(function( data ){
            if(data.success){
                tVue.$data.teachers = data.teachers;
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});