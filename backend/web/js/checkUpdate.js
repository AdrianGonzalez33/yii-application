$('#myCheck').on( 'change', function() {
    // console.log("entra123");
    if( $(this).is(':checked') ) {
        // console.log($(this).val());
        alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
    }
});
