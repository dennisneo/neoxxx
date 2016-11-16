var fVue = new Vue({
    el:'#fDiv',
    data:{
        payments:[]
    },
    methods:{
        getPayments:function()
        {
            $.get( subdir+'/ajax/finance/getpayments' )
            .done(function( data ){
                if(data.success){
                    fVue.$data.payments = data.payments
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
        this.getPayments();

        $('#date_from').datepicker();
        $('#date_to').datepicker();
    }
});

$( document ).ready(
    function(){
        $('#date_from').datepicker();
        $('#date_to').datepicker();
    }
);
