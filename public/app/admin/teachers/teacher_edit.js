
var tVue = new Vue({
    el:'#tDiv',
    data:{
        teachers:[]
    },
    methods:{
        save:function()
        {
            $('.btn').prop('disabled', true );

            $.post( subdir+'/ajax/teacher/save', $('#t-form').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success('success');
                    window.location.href=subdir+'/admin/teacher/'+$('#user_id').val()
                }else{
                   toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
            })
            .error(function( data ){
                $('.btn').prop('disabled', false );
                toastr.error( 'Ooops something went wrong!' );
            });
        },
        cancel:function(){

        }
    },
    ready:function(){
    }
});


$(document).ready(function(){
    $('#date1').combodate({
        minYear: 1950,
        maxYear: 2016,
        minuteStep: 10,
        customClass : 'date-control'
    });
});