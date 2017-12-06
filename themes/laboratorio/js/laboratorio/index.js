$(document).ready(function(){
    recargar_lista_perfil_usuario();
    recargar_tareas_usuario();
    recargar_actividad_laboratorio();
});


function recargar_lista_perfil_usuario() {
    var base_url = $('#base_url').val();
    var url = base_url + 'site/listaPerfilUsuario';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#lista_perfil_usuario').html(html);
            $('#lista_perfil_usuario').fadeIn();
            //setTimeout('recargar_lista_perfil_usuario()', 10500);
        }
    });
}

function recargar_tareas_usuario() {
    var base_url = $('#base_url').val();
    var url = base_url + 'tarea/tareasUsuario';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#tareas_usuario').html(html);
            $('#tareas_usuario').fadeIn();
            //setTimeout('recargar_tareas_usuario()', 6500);
        }
    });
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
        cache: false
    });
}

function ampliar_tarea(id) {
    $('.detalle_tarea').hide();
    $('#detalle_tarea_'+id).show();
    $('#modal_detalle_tarea').modal('show');
}

function confirmar_eliminar_tarea(id) {
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
            $('#tarea_'+tarea_id).slideUp(function() {
                $('#tarea_'+tarea_id).remove();
                if ($('#tareas_usuario li').length === 0) {
                    $('.task-content').hide();
                    $('#ver_tareas').hide();
                    $('#sin_tareas').fadeIn();
                }
            });
        }
    });
}

function recargar_actividad_laboratorio() {
    var base_url = $('#base_url').val();
    var url = base_url + 'site/actividadLaboratorio';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#actividad_laboratorio').html(html);
            $('#actividad_laboratorio').fadeIn();
            setTimeout('recargar_actividad_laboratorio()', 4500);
        }
    });
}