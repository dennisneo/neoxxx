var sVue = new Vue({
    el:'#sDiv',
    data:{
        salaries: [],
        salary:{},
        daily_data:[]
    },
    methods:{
        init(){
            let vm = this;
            $.get( subdir+'/ajax/admin/salaries')
            .done(function( data ){
                if( data.success){
                    vm.salaries = data.salaries;
                }else{
                    toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        openDaily( history_id ){
            let vm = this;
            $('#dailyModal').modal();
            this.salary = $.grep(this.salaries, function( s){
                return  s.salary_history_id == history_id ;
            })[0];
            $.get( subdir+'/ajax/admin/ds' , { history_id: history_id } )
            .done(function( data ){
                if( data.success){
                    vm.daily_data = data.ds
                }else{
                    toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        filter(){

        }
    },
    mounted(){
        this.init();
    }
});

$(document).ready(function(){
    $( "#from" ).datepicker( { dateFormat: 'yy-mm-dd' } );
    $( "#to" ).datepicker( { dateFormat: 'yy-mm-dd' }  );
});