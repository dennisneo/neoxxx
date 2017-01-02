
var peVue = new Vue({
    el:'#peDiv',
    ready:function(){
        this.getRecords();
    },
    data:{
        questions:[],
        choices:[],
        question:{},
        total: 0,
        page_count: [1],
        current_page : 1
    },
    methods:{
        goToPage:function( e )
        {
            this.$data.current_page =  $(e.target).attr('data-page');
            $('#page').val( this.$data.current_page );
            this.getRecords();
        },
        goToNext:function()
        {
            this.$data.current_page =  parseInt( this.$data.current_page ) + 1;
            $('#page').val( this.$data.current_page );
            this.getRecords();
        },
        goToPrev:function()
        {
            this.$data.current_page =  parseInt( this.$data.current_page ) - 1;
            $('#page').val( this.$data.current_page );
            this.getRecords();
        },
        getRecords:function()
        {
            $.get( subdir+'/ajax/admin/pe/get', $('#peForm').serialize() )
                .done(function( data ){
                    if( data.success ){
                        peVue.$data.questions = data.questions;
                        peVue.$data.choices = data.choices;
                        peVue.$data.total = data.total;
                        peVue.$data.page_count =  data.page_count;
                    }else{
                        toastr.error( data.message );
                    }
                    $('.loading').addClass( 'hide' )
                })
                .error(function( data ){

                });
        }
    }
});