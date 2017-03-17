var pVue = new Vue({
    el:'#pDiv',
    data:{
        payments:[],
        total_entries: 0,
        total_amount: 0,
        loading: false
    },
    methods:{
        getPayments(){
            let vm = this;
            vm.payments = [];
            vm.loading  =   true;
            $.get( subdir+'/ajax/admin/gph' , $('#pForm').serialize() )
            .done(function( data ){
                if( data.success){
                    vm.loading  =   false;
                    vm.payments = data.payments;
                    vm.total_entries = data.total_entries;
                    vm.total_amount = data.sum;
                }else{
                    toastr.error( data.message );
                }
            }).error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        filter(){
            this.getPayments();
        }
    },
    ready:function(){
        this.getPayments();
    }
});

$(document).ready(function(){
    $( "#from" ).datepicker( { dateFormat: 'yy-mm-dd' } );
    $( "#to" ).datepicker( { dateFormat: 'yy-mm-dd' }  );
});