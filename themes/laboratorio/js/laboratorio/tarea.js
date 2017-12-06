$(document).ready(function(){
    recargar_listado_tareas();
});

function recargar_listado_tareas() {
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/listadoTareas';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#listado_tareas').html(html);
        }
    });
}

function ampliar_tarea(id) {
    $('.detalle_tarea').hide();
    $('#detalle_tarea_'+id).show();
    $('#modal_detalle_tarea').modal('show');
}

function tarea_realizada(tarea) {
    var tarea_id = $(tarea).attr('tarea');
    var estado = 1;
    if($(tarea).is(':checked'))
        estado = 0;
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/marcarTareaRealizada';
    $.ajax({
        type: "POST",
        url: url,
        data: {tarea_id: tarea_id, estado: estado},
        cache: false,
        success: function(){
            if (!estado) {
                $(tarea).parent().parent().addClass('realizada');
                $(tarea).parent().find('span').html('a');
            }
            else {
                $(tarea).parent().parent().removeClass('realizada');
                $(tarea).parent().find('span').html('b');
            }
        }
    });
}

function confirmar_eliminar(id) {
    $('#tarea_seleccionada').val(id);
    $('#modal_eliminar_tarea').modal('show');
}

function eliminar_tarea() {
    var tarea_id = $('#tarea_seleccionada').val();
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/eliminarTarea';
    $.ajax({
        type: "POST",
        url: url,
        data: {tarea_id: tarea_id},
        cache: false,
        success: function(){
            recargar_listado_tareas();
        }
    });
}

function agregar_tarea_form() {
    $('#btn_agregar_tarea').hide();
    CKEDITOR.instances.Tarea_descripcion.setData('');
    $('#Tarea_titulo').val('');
    $('#asignar_a').val(0);
    $('#error_message').hide();
    $('#agregar_tarea_wrapper').slideDown();
}

function cancelar_agregar_tarea() {
    $('#agregar_tarea_wrapper').slideUp(function() {
        $('#btn_agregar_tarea').show();
    });
}

function agregar_tarea() {
    $('#error_message').hide();
    var error = '';

    // Campo Más Información
    if (error == '') {
        var titulo = $.trim($('#Tarea_titulo').val());
        if (titulo.length == 0) {
            error = 'Debe ingresar el título.';
        }
    }
    if (error != '') {
        $('#error_message #message').html(error);
        $('#error_message').fadeIn();
    }
    else {
        var descripcion = CKEDITOR.instances.Tarea_descripcion.getData();
        var asignar_a = $('#Tarea_asignar_a').val();
        var base_url = $('#base_url').val();
        var url = base_url + 'tarea/agregarTarea';
        $.ajax({
            type: "POST",
            url: url,
            data: {titulo: titulo, descripcion: descripcion, asignar_a: asignar_a},
            cache: false,
            success: function(){
                recargar_listado_tareas();
                cancelar_agregar_tarea();
            }
        });
    }
}

function editar_tarea_form(id) {
    $('#tarea_seleccionada').val(id);
    $('#agregar_tarea_wrapper').slideUp();
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/editarTituloTarea';
    $.ajax({
        type: "POST",
        url: url,
        data: {id: id},
        cache: false,
        success: function(html){
            $('#Tarea_titulo_editar').val(html);
            editar_descripcion_tarea(id);
        }
    });
}

function editar_descripcion_tarea(id) {
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/editarDescripcionTarea';
    $.ajax({
        type: "POST",
        url: url,
        data: {id: id},
        cache: false,
        success: function(html){
            CKEDITOR.instances.Tarea_descripcion_editar.setData(html);
            editar_asignar_a_tarea(id);
        }
    });
}

function editar_asignar_a_tarea(id) {
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/editarAsignarATarea';
    $.ajax({
        type: "POST",
        url: url,
        data: {id: id},
        cache: false,
        success: function(valor){
            $('#error_message_editar').hide();
            $('#Tarea_asignar_a_editar').val(valor);
            $('#btn_agregar_tarea').hide();
            $('#editar_tarea_wrapper').slideDown();
        }
    });
}

function cancelar_editar_tarea() {
    $('#editar_tarea_wrapper').slideUp(function() {
        $('#btn_agregar_tarea').show();
    });
}

function editar_tarea() {
    $('#error_message_editar').hide();
    var error = '';

    if (error == '') {
        var titulo = $.trim($('#Tarea_titulo_editar').val());
        if (titulo.length == 0) {
            error = 'Debe ingresar el título.';
        }
    }
    if (error != '') {
        $('#error_message_editar #message_editar').html(error);
        $('#error_message_editar').fadeIn();
    }
    else {
        var tarea_id = $('#tarea_seleccionada').val();
        var descripcion = CKEDITOR.instances.Tarea_descripcion_editar.getData();
        var asignar_a = $('#Tarea_asignar_a_editar').val();
        var base_url = $('#base_url').val();
        var url = base_url + 'tarea/editarTarea';
        $.ajax({
            type: "POST",
            url: url,
            data: {tarea_id: tarea_id, titulo: titulo, descripcion: descripcion, asignar_a: asignar_a},
            cache: false,
            success: function(){
                recargar_listado_tareas();
                cancelar_editar_tarea();
            }
        });
    }
}









function editar_info_adicional() {
    $('#error_message').hide();
    var error = '';

    // Campo Más Información
    if (error == '') {
        var informacion = CKEDITOR.instances.Experimento_editar_informacion.getData();
        if (informacion.length == 0) {
            error = 'Debe ingresar información.';
        }
    }
    if (error != '') {
        $('#error_message #message').html(error);
        $('#error_message').fadeIn();
    }
    else {
        var base_url = $('#base_url').val();
        var estado_id = $('#estado_id').val();
        var url = base_url + 'experimento/editarInformacionAdicional';
        $.ajax({
            type: "POST",
            url: url,
            data: {estado_id: estado_id, informacion: informacion},
            cache: false,
            success: function(){
                recargar_listado_info_adicional();
                ocultar_form_editar_info_adicional();
                $('.mensaje_info_editada_ok').fadeIn('slow');
                setTimeout('ocultar_mensaje_info_editada_ok()', 2000);
            }
        });
    }
}

function ocultar_mensaje_info_editada_ok() {
    $('.mensaje_info_editada_ok').fadeOut('slow');
}

function ocultar_form_editar_info_adicional() {
    $('#estado_id').val(0);
    $('#editar_info_wrapper').slideUp('slow');
    CKEDITOR.instances.Experimento_editar_informacion.setData('');
}


function eliminar_info_adicional() {
    var base_url = $('#base_url').val();
    var estado_id = $('#estado_id').val();
    var url = base_url + 'experimento/eliminarInformacionAdicional';
    $.ajax({
        type: "POST",
        url: url,
        data: {estado_id: estado_id},
        cache: false,
        success: function(){
            recargar_listado_info_adicional();
            ocultar_form_editar_info_adicional();
            $('.mensaje_info_eliminada_ok').fadeIn('slow');
            setTimeout('ocultar_mensaje_info_eliminada_ok()', 2000);
        }
    });
}

function ocultar_mensaje_info_eliminada_ok() {
    $('.mensaje_info_eliminada_ok').fadeOut('slow');
}