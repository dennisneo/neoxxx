
var tVue = new Vue({
    el:'#tDiv',
    data:{
        teachers:[],
        teacher:{},
        records:[]
    },
    methods:{
        openPerformanceRecord:function( teacher_id ){

        },
        openSettings:function( id ) {
            n = this.teachers;
            $('#settingsModal').modal();
            for( i=0; i < n.length; i++ ){
                d = n[i];
                if(d.id == id ){
                    this.teacher = d;
                    $('#rate').val(d.rate_per_hr );hg
                    return;
                }
            }

        },
        saveSettings:function(){
            $.post(subdir+'/ajax/teacher/saveSettings' , $('#settingsForm').serialize())
            .done(function( data ){
                if(data.success){
                   toastr.success('Teacher settings successfully updated');
                    $('#settingsModal').modal( 'toggle' );
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
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