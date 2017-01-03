
var tVue = new Vue({
    el:'#tDiv',
    data:{
        records:[],
        page_count:[1],
        total:0
    },
    methods:{

    },
    ready:function(){
        $.get( subdir+'/ajax/teacher/performance' , { tid: $('#teacher_id').val() })
        .done(function( data ){
            if(data.success){
                tVue.$data.records = data.records;
                tVue.$data.page_count = data.page_count;
                tVue.$data.total = data.total;
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

    }
);
