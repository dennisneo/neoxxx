
var rVue = new Vue({
    el:'#rDiv',
    data:{
        teachers:[],
        teacher:{},
        records:[]
    },
    methods:{
        init(){
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
        },
        newRecord:function()
        {
            $('#performanceModal').modal();
        },
        savePerformanceRecord:function(){
            $('.btn').prop('disabled', true );
            $.post( subdir+'/ajax/teacher/spr' , $('#pForm').serialize() )
                .done(function( data ){
                    if(data.success){
                        toastr.success( 'Teacher performance report successfully submitted' );
                        rVue.$data.records.push( data.record );
                        $('#performanceModal').modal( 'toggle' );
                    }else{
                        toastr.error( data.message );
                    }
                    $('.btn').prop('disabled', false );
                })
                .error(function( data ){
                    toastr.error( 'Something went wrong' );
                    $('.btn').prop('disabled', false );
                });
        }
    },
    ready:function(){
        this.init();
    }
});


$(document).ready(function(){

    $( "#teacher" ).autocomplete({
        serviceUrl: subdir+'/ajax/teachers/gta',
        dataType: 'json',
        paramName: 'q',
        deferRequestBy:200,
        onSelect: function (suggestion) {
            $('#teacher_id').val( suggestion.data );
        }
    });
    $('#date_of_occurence').datepicker();

});