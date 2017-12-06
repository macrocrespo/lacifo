/**
 * Función para modificar el atributo action del formulario de eliminación
 * @param {type} id
 * @returns {undefined}
 */
function delete_row(id) {
    var base_url = $('#base_url').val();
    var controller = $('#controller').val();
    var validar_eliminacion = $('#validar_eliminacion').val();
    if (validar_eliminacion == 1) {
        var url = base_url + controller + '/validarEliminacion/'+id;
        $.ajax({
            type: "GET",
            url: url,
            cache: false,
            success: function(respuesta){
                respuesta = parseInt(respuesta);
                if (respuesta == 1) { // Puede eliminar
                    $('#confirmar_eliminar #delete_row').attr('action', base_url+controller+'/delete/'+id);
                    $('#confirmar_eliminar').modal('show');
                }
                else {
                    $('#mensaje_no_eliminar').modal('show');
                }
            }
        });
    }
    else {
        $('#confirmar_eliminar #delete_row').attr('action', base_url+controller+'/delete/'+id);
        $('#confirmar_eliminar').modal('show');
    }
}

var base_url = $('#base_url').val();
$(document).ready(function(){
    $('#error_message').hide();
    
    $('.title_in_modal').each(function(){
        $(this).attr('onclick', 'show_title_in_modal(this)');
    });
});

function goto(id, margin_top, notime) {
    var top = $("#"+id).offset().top;
    var time = 1000;
    if (margin_top)
        top = top - 20;
    if (notime)
        time = 0;
    $('html, body').animate({
        scrollTop: top
    }, time);
}

function show_title_in_modal(link) {
    var txt = $(link).attr('title');
    $('#title_in_modal .modal-body').html(txt);
    $('#title_in_modal').modal('show');
}

// Función para validar un formulario con una lista de campos
function validarForm(e, tipo, campos) {
    if (!e.isDefaultPrevented()) {
        $('#error_message').hide();
        var error = '';
        var value = '';
        var focus = '';
        for (var i in campos) {
            if (error == '') {
                value = $.trim($('#'+tipo+'_'+i).val());
                if (value.length == 0) {
                    error = '<i class="icon-warning-sign"></i> Debe ingresar '+campos[i]+'.';
                    focus = i;
                }
            }
        }

        if (error != '') {
            e.preventDefault();
            $('#error_message #message').html(error);
            $('#error_message').fadeIn();
            $('#'+tipo+'_'+focus).focus();
        }
    }
}