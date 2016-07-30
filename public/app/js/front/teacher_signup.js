
document.addEventListener('invalid', function(e){
    var element = $(e.target);
    element.focus()
}, true);


$('#sb').click(
    function( e ){
        e.preventDefault();
        $.post( subdir+'/ajax/application/s' , $('#sForm').serialize() )
        .done( function( data ){

        }).error(function( data ){

        });
    }
);
