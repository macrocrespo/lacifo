var base_url = $('#base_url').val();
$(document).ready(function(){
    $('#tipo_a_asignar').change(function(){
        var tipo = $(this).val();
        $.ajax({
            url: base_url+'permiso/listado',
            data: {tipo: tipo},
            type: 'POST',
            success: function(html){
                $('#listado').html(html);
            }
        });
    });
});

function asignar_permiso(seccion_id) {
    var id = $('#id').val();
    var tipo = $('#tipo').val();
    $.ajax({
        url: base_url+'permiso/asignar_permiso',
        data: {tipo: tipo, id: id, seccion_id: seccion_id},
        type: 'POST',
        success: function(){
            // $('#permisos_por_asignar .listado tr#'+seccion_id).remove();
            reload_permisos(1);
        }
    });
}

function quitar_permiso(id) {
    var tipo = $('#tipo').val();
    $.ajax({
        url: base_url+'permiso/quitar_permiso',
        data: {tipo: tipo, id: id},
        type: 'POST',
        success: function(){
            reload_permisos(1);
        }
    });
}

function reload_permisos(por_asignar) {
    var id = $('#id').val();
    var tipo = $('#tipo').val();
    $.ajax({
        url: base_url+'permiso/permisos_asignados',
        data: {tipo: tipo, id: id},
        type: 'POST',
        success: function(html){
            $('#permisos_asignados .panel-body').html(html);
        }
    });
    
    if (por_asignar) {
        $.ajax({
            url: base_url+'permiso/permisos_por_asignar',
            data: {tipo: tipo, id: id},
            type: 'POST',
            success: function(html){
                $('#permisos_por_asignar .panel-body').html(html);
            }
        });
    }
}
