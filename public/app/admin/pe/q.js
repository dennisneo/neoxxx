

var qVue = new Vue({
    el:'#qDiv',
    ready:function(){

    },
    data:{
        questions:[],
        question:{},
        choices:[]
    },
    methods:{
        saveQuestion:function(){

            var c_arr = new Array;
            for( i=0; i < qVue.$data.choices.length; i++ ){
                d = qVue.$data.choices[ i ];
                c_arr.push( d.choice );
            }

            choices = '&c[]='+c_arr.join( '&c[]=' ) ;

            $.post( subdir+'/ajax/admin/pe/sq',  $('#pForm').serialize()+choices )
                .done(function( data ){

                })
                .error(function( data ){

                });

        },
        addChoice:function()
        {
            var choice = $('#choice').val();
            if( choice ){
                d = { choice: choice };
                //check if duplicate
                qVue.$data.choices.push( d )
                $('#choice').val( '' );
                $('#choice').focus();
            }
        }
    }
});