$('#myCheck').on( 'change', function() {
    if( $(this).is(':checked') ) {
        alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
    } else {
        alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
    }
});
