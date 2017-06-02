
var aVue = new Vue({
    el:'#aDiv',
    data:{
        applicants :[]
    },
    methods:{
        getApplicants:function(){
            $.get( subdir+'/ajax/admin/a/get')
                .done(function( data ){
                    if(data.success){
                        aVue.$data.applicants = data.applicants
                    }else{
                        toastr.error( data.message );
                    }
                    $('.loading').addClass( 'hide' );
                }).error( function( data ){

                } );
        },
        qClick( e ){
            if( e.which == 13 ){
                this.searchApplicants();
            }
        },
        searchApplicants(){
            let vm = this;
            let btn = $('#searchButton');
            let h = btn.html();

            $('.btn').prop('disabled', true );
            btn.html( '<i class="fa fa-spin fa-refresh"></i>' );

            $.get(subdir+'/ajax/admin/applicants' , { q : $('#q').val() , status: $('#status').val() })
            .done(function( data ){
                if( data.success){
                    vm.applicants = data.applicants
                }else{
                    toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
                btn.html( h );
            })
            .error(function( data ){
                toastr.error('Something went wrong');
                $('.btn').prop('disabled', false );
                btn.html( h );
            });
        },
        manage:function(){
            $('#aModalDiv').modal()
        }
    },
    ready:function(){
        this.getApplicants();
    }
});