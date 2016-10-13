
var rVue = new Vue({
    el:'#rDiv',
    data:{
        teachers:[],
        teacher:{},
        records:[]
    },
    methods:{
        newRecord:function()
        {
            alert('hello');
            $('#performanceModal').modal();
        }
    },
    ready:function(){
        $.get( subdir+'/ajax/teacher/gpr' )
            .done(function( data ){
                if(data.success){
                    rVue.$data.records  = data.records
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