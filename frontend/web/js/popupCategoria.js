$(function(){
   //obtiene cuando se pulsa crear categoria
    $('#modalButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'))
    })
});