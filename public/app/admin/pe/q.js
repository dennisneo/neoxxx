

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

            if( qVue.$data.choices.length < 2 ){
                toastr.error( ' Question need to have 2 or more choices.' );
                return
            }
            /**
            var c_arr = new Array;
            for( i=0; i < qVue.$data.choices.length; i++ ){
                d = qVue.$data.choices[ i ];
                c_arr.push( encodeURIComponent( d.choice ) );
            }

            choices = '&c[]='+c_arr.join( '&c[]=' ) ;
            ***/
            $('.btn').prop('disabled', true );

            $.post( subdir+'/ajax/admin/pe/sq',  $('#pForm').serialize() )
                .done(function( data ){
                    if(data.success){
                       toastr.success( 'Question successfully saved' );
                       window.location.href=subdir+'/admin/pe';
                    }else{
                       toastr.error( data.message );
                    }

                    $('.btn').prop('disabled', false );
                })
                .error(function( data ){
                    toastr.error( 'Something went wrong' );
                });

        },
        addChoice:function()
        {
            var choice = $('#choice').val();
            if( choice ){
                //choice_key = Math.random().toString(36).slice(2);
                d = { choice: choice  };
                //check if duplicate
                qVue.$data.choices.push( d );
                $('#choice').val( '' );
                $('#choice').focus();
            }
        },
        editChoice:function( idx )
        {
            $('.c-group-text').removeClass( 'hide' );
            $('.c-group').addClass( 'hide' );
            div = '#div-'+idx;
            div_text = '#div-text-'+idx;
            $(div).removeClass( 'hide');
            $(div_text).addClass( 'hide');
        },
        saveChoice:function( i )
        {
            v = $( '#input-'+i).val();
            c = { choice: v };
            qVue.$data.choices.$set( i ,  c )
        },
        removeChoice:function( i )
        {
            d = qVue.$data.choices[i];
            qVue.$data.choices.$remove( d );
        }
    }
});


$('#choice').keydown(
    function( event ){
        if ( event.which == 13 ) {
            qVue.addChoice();
        }
    }
);

