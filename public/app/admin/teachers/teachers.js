
var tVue = new Vue({
    el:'#tDiv',
    data:{
        teachers:[],
        teacher:{},
        records:[],
        records_loading: false
    },
    methods:{
        openPerformanceRecord:function( teacher_id ){

            let vm = this;

            $('#performanceModal').modal();
            this.teacher = $.grep( this.teachers, function( t ){
               return t.id == teacher_id;
            })[0];

            vm.loading_records = true;
            vm.records  =   [];

            $.get( subdir+'/ajax/teacher/gpr' , { teacher_id : teacher_id } )
            .done(function( data ){
                if( data.success){
                    vm.records = data.records
                }else{
                    toastr.error( data.message );
                }
                vm.loading_records = false;
            })
            .error(function( data ){
                toastr.error('Something went wrong');
                vm.loading_records = false;
            });

        },
        openSettings:function( id ) {
            n = this.teachers;
            $('#settingsModal').modal();
            for( i=0; i < n.length; i++ ){
                d = n[i];
                if(d.id == id ){
                    this.teacher = d;
                    $('#rate').val(d.rate_per_hr );
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