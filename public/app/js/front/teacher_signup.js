
document.addEventListener('invalid', function(e){
    var element = $(e.target);
    element.focus()
}, true);

$(document).ready(function(){
    $('#date1').combodate({
        minYear: 1950,
        maxYear: 2016,
        minuteStep: 10,
        customClass : 'date-control'
    });
});

$('#sb').click(
    function( e ){

        e.preventDefault();
        $( '#sb' ).html( '<i class="fa fa-spin fa-refresh"></i>' );

        $.post( subdir+'/ajax/application/s' , $('#sForm').serialize() )
        .done( function( data ){
            if(data.success){
                location.href = subdir+'/application/success?uid='+data.uid+'&e='+data.e;
            }else{

               toastr.error( data.message );
            }
            $( '#sb' ).html( 'Submit' );
        }).error(function( data ){
            toastr.error( 'Something went wrong' );
            $( '#sb' ).html( 'Submit' );
        });
    }
);
