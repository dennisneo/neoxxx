
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
        manage:function(){
            $('#aModalDiv').modal()
        }
    },
    ready:function(){
        this.getApplicants();
    }
});