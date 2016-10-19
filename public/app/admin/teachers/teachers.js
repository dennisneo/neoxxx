
var tVue = new Vue({
    el:'#tDiv',
    data:{
        teachers:[],
        teacher:{},
        records:[]
    },
    methods:{
        openPerformanceRecord:function( teacher_id )
        {
        }

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


$(document).ready(function(){
    $('#date_of_occurence').datepicker();
});