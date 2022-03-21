$( document ).ready(function() {
    $('.btn-success').on('click',function(){
        var id = $(this).data('id');
        $.post( "save.php", {id: id} ,function( data ) {
                console.log(data);
        });
    });
});