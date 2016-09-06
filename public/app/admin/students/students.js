
var sVue = new Vue({
    el:'#sDiv',
    data:{
        students:[]
    },
    methods:{

    },
    ready:function(){
        $.get(  subdir+'/ajax/students/getall')
        .done(function( data ){
            if(data.success){
                sVue.$data.students = data.students;
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});