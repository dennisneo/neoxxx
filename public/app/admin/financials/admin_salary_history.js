var sVue = new Vue({
    el:'#sDiv',
    data:{
        salaries: [],
        salary:{},
        daily_data:[],
        more_search_options :false,
        loading:false
    },
    methods:{
        init(){
            let vm = this;
            this.loading = true;
            $.get( subdir+'/ajax/admin/salaries')
            .done(function( data ){
                if( data.success){
                    vm.salaries = data.salaries;
                }else{
                    toastr.error( data.message );
                }
                vm.loading = false;

            }).error( function( data ){
                toastr.error( 'Something went wrong' );
                vm.loading = false;
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
        filter( e ){
            let btn = $(e.target);
            let h   = btn.html();

            $('.btn').prop('disabled', true );
            btn.html( '<i class="fa fa-spin fa-refresh"></i>' );

            let vm = this;
            this.loading = true;
            $.get( subdir+'/ajax/admin/fsh' , $('#pForm').serialize())
            .done(function( data ){
                if( data.success){
                    vm.salaries = data.salaries
                }else{
                    toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
                btn.html( h );
                vm.loading = false;
            })
            .error(function( data ){
                toastr.error('Something went wrong');
                vm.loading = false;
            });
        }
    },
    mounted(){
        this.init();
    }
});

$(document).ready(function(){
    $( "#from" ).datepicker( { dateFormat: 'yy-mm-dd' } );
    $( "#to" ).datepicker( { dateFormat: 'yy-mm-dd' }  );

    $( "#teacher" ).autocomplete({
        source: subdir+'/ajax/teachers/gtav2',
        minLength: 2,
        select: function( event, ui ) {
            $('#teacher_id').val( ui.item.id );
        }
    });

});

$('#teacher').blur(
    function(){

        if( $('#teacher').val().length == 0 ){
            $('#teacher_id').val( 0 )
        }
    }
);