
var tVue = new Vue({
    el:'#tDiv',
    data:{
        records:[]
    },
    methods:{
        getSalaryRecords()
        {
            let vm = this;
            $.get(subdir+'/ajax/teacher/gsr' , { teacher_id:$('#teacher_id').val() })
            .done(function( data ){
                if(data.success){
                    vm.records = data.records;
                }else{
                    toastr.error( data.message );
                }
            }).error(function( data ){
                toastr.error('Something went wrong');
            });
        }
    },
    ready:function(){
        this.getSalaryRecords();
    }
});

$( document ).ready(
    function(){

    }
);
