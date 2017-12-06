var base_url = $('#base_url').val();
$(document).ready(function(){
    $('#experimento-form').submit(function(e){
        validarExperimentoPaso1(e);
    });
    
    $('#advanced_search_form').submit(function(e){
        e.preventDefault();
        advanced_search();
    });
    
    var idView = $('#idView').val();
    switch (idView) {
        case 'admin':
            recargar_resumen_experimentos();
            recargar_listado_experimentos();
            load_advanced_search_datepickers();
            break;
        case 'agregarProductos':
            var id = $('#id').val();
            cargarProductosPorExperimento(id);
            busqueda_productos();
            break;
        case 'cargarSeries':
            $('.multi-select').multiSelect({
                selectableHeader: 'Series disponibles',
                selectionHeader: 'Series seleccionadas',
                afterSelect: function(serie) {
                    var serie2 = String(serie);
                    serie2 = serie2.split("-").join("_");
                    var id_select = $('#'+serie2+'-selectable').parent().parent().parent().parent().parent().attr('id');
                    var id_producto = id_select.split("_");
                    id_producto = id_producto[1];
                    //var cant_selected = $('#'+id_select+' .ms-selection li.ms-selected').length;
                    var series_to_select = $('#series_to_select_'+id_producto).val();
                    series_to_select--;
                    $('#series_to_select_'+id_producto).val(series_to_select);
                    if (series_to_select == 0) {
                        $('.seleccionar_series_'+id_producto).hide();
                        $('.series_seleccionadas_'+id_producto).fadeIn();
                        $('#ms-producto_'+id_producto+' .ms-selectable .ms-list li.ms-elem-selectable').addClass('disabled');
                    }
                    else {
                        $('.seleccionar_series_'+id_producto+' .alert-warning').html('Se deben seleccionar '+series_to_select+' series.');
                        $('#ms-producto_'+id_producto+' .ms-selectable .ms-list li.ms-elem-selectable').show();
                        $('#ms-producto_'+id_producto+' .ms-selectable .ms-list li.ms-selected').hide();
                    }
                },
                afterDeselect: function(serie) {
                    var serie2 = String(serie);
                    serie2 = serie2.split("-").join("_");
                    var id_select = $('#'+serie2+'-selection').parent().parent().parent().parent().parent().attr('id');
                    var id_producto = id_select.split("_");
                    id_producto = id_producto[1];
                    var series_to_select = $('#series_to_select_'+id_producto).val();
                    series_to_select++;
                    $('#series_to_select_'+id_producto).val(series_to_select);
                    if (series_to_select > 0) {
                        $('.series_seleccionadas_'+id_producto).hide();
                        $('.seleccionar_series_'+id_producto).fadeIn();
                        $('.seleccionar_series_'+id_producto+' .alert-warning').html('Se deben seleccionar '+series_to_select+' series.');
                        $('#ms-producto_'+id_producto+' .ms-selectable .ms-list li.ms-elem-selectable').removeClass('disabled');
                        $('#ms-producto_'+id_producto+' .ms-selectable .ms-list li.ms-selected').hide();
                    }
                },
                afterInit: function(container) {
                    var id_select = (container).attr('id');
                    var id_producto = id_select.split("_");
                    id_producto = id_producto[1];
                    var series_to_select = $('#series_to_select_'+id_producto).val();
                    if (series_to_select == 0) {
                        $('.seleccionar_series_'+id_producto).hide();
                        $('.series_seleccionadas_'+id_producto).fadeIn();
                        $('#ms-producto_'+id_producto+' .ms-selectable .ms-list li.ms-elem-selectable').addClass('disabled');
                    }
                }
            });
            break;
        case 'agregarEquipos':
            var id = $('#id').val();
            cargarEquiposPorExperimento(id);
            busqueda_equipos();
            break;
        case 'infoAdicional':
            recargar_listado_info_adicional();
            $('#tab1 a').on('click', function() {
                $('#btn_agregar_info').hide();
                $('#btn_editar_info').show();
                $('#error_message').hide();
            });
            $('#tab2 a').on('click', function() {
                $('#btn_editar_info').hide();
                $('#btn_agregar_info').show();
                $('#error_message').hide();
            });
            break;
        case 'cambiarEstado':
            $('#error_message').hide();
            var estado = $('#estado').val();
            if (estado == 'FINALIZADO')
                $('#error_message').fadeIn();
            break;
        case 'detalles':
            $('#info_inicial .alert-success .btn-success').hide();
            break;
    }
    
    $('#buscar-productos-form').submit(function(e){
        buscarProductos(e);
    });
    
    $('#buscar-equipos-form').submit(function(e){
        buscarEquipos(e);
    });
});

function ver_experimentos_por_estado(estado) {
    $("#advanced_search_form").get(0).reset();
    $('#advanced_search_form #estado').val(estado);
    advanced_search();
    $('#btn-reset-estados-wrapper').fadeIn();
    goto('listado_experimentos_wrapper', 1);
}

function reset_estados() {
    $("#advanced_search_form").get(0).reset();
    recargar_listado_experimentos();
    $('#btn-reset-estados-wrapper').fadeOut();
}

/* ------------------ INFORMACIÓN INICIAL ----------------- */

// Función para validar el formulario inicial de expermientos
function validarExperimentoPaso1(e) {
    if (!e.isDefaultPrevented()) {
        $('#error_message').hide();
        var error = '';
        // Título
        var titulo = $.trim($('#Experimento_titulo').val());
        if (titulo.length == 0) {
            error = '<i class="icon-warning-sign"></i> Debe ingresar el título.';
        }
        // Descripción
        if (error == '') {
            var descripcion = CKEDITOR.instances.Experimento_descripcion.getData();
            if (descripcion.length == 0) {
                error = '<i class="icon-warning-sign"></i> Debe ingresar la descripción.';
            } 
        }
        // Experimento_condiciones
        if (error == '') {
            var condiciones = CKEDITOR.instances.Experimento_condiciones.getData();
            if (condiciones.length == 0) {
                error = '<i class="icon-warning-sign"></i> Debe ingresar las condiciones.';
            } 
        }
        // Experimento_resultados
        if (error == '') {
            var resultados = CKEDITOR.instances.Experimento_resultados.getData();
            if (resultados.length == 0) {
                error = '<i class="icon-warning-sign"></i> Debe ingresar los resultados.';
            } 
        }

        if (error != '') {
            e.preventDefault();
            $('#error_message #message').html(error);
            $('#error_message').fadeIn();
        }
    }
}

/* ------------------ AGREGAR PRODUCTOS ----------------- */

// Función para cargar el listado de productos asociados al experimento
function cargarProductosPorExperimento(id) {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/productosPorExperimento/'+id;
    $.ajax({
          type: "POST",
          url: url,
          cache: false,
          success: function(html){
            $('#productos_por_experimento').html(html);
            var cant_productos = $('#productos_por_experimento #cant_productos').val();
            if (cant_productos == 0) {
                $('#productos_por_experimento .mensaje_sin_productos').fadeIn();
            }
          }
    });
}

// Función para validar el formulario inicial de expermientos
function buscarProductos(e) {
    if (!e.isDefaultPrevented()) {
        e.preventDefault();
        busqueda_productos();
    }
}

function busqueda_productos() {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/buscarProductos';
    $.ajax({
          type: "POST",
          url: url,
          data: $('#buscar-productos-form').serialize(),
          cache: false,
          success: function(html){
            $('#busqueda_productos').html(html);
            $('#busqueda_productos .dataTables_length').hide();
          }
    });
}

function verificar_producto(id) {
    $('.error_icon').addClass('hidden');
    $('#cantidad_'+id).removeClass('btn-danger');
    var serie = $('#usa_serie_'+id).val();
    var cantidad = parseInt($('#cantidad_'+id).val());
    if (!cantidad) cantidad = 0;
    var disponible = $('#disponible_'+id).val();
    var error = false;
    if (cantidad == 0) {
        $('#error_sin_cantidad_'+id).removeClass('hidden');
        error = true;
        $('#cantidad_'+id).addClass('btn-danger');
        $('#cantidad_'+id).attr('title', 'La cantidad debe ser superior a 0');
        $('#cantidad_'+id).focus();
    }

    if (cantidad > disponible) {
        $('#error_cantidad_'+id).removeClass('hidden');
        error = true;
        $('#cantidad_'+id).addClass('btn-danger');
        $('#cantidad_'+id).attr('title', 'La cantidad no debe superar '+disponible);
        $('#cantidad_'+id).focus();
    }
    
    if (!error) {
        agregar_producto(id, cantidad, disponible, serie);
    }
}

function agregar_producto(id, cantidad, disponible, serie) {    
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/agregarProducto';
    var experimento_id = $('#id').val();
    $.ajax({
          type: "POST",
          url: url,
          data: {id: id, cantidad: cantidad, disponible: disponible, serie: serie, experimento_id: experimento_id},
          cache: false,
          success: function(html){
            $('#error_message').fadeOut();
            $('#row'+id).addClass('selected');
            $('#usa_serie_'+id).attr('disabled', 'disabled');
            $('#cantidad_'+id).attr('disabled', 'disabled');
            $('#btn_agregar_'+id).addClass('hidden');
            $('#btn_agregado_'+id).removeClass('hidden');
            
            $('#productos_por_experimento').html(html);
            $('.mensaje_producto_agregado').fadeIn('slow');
            setTimeout('ocultar_mensaje_producto_agregado()', 2000);
          }
    });
}

function ocultar_mensaje_producto_agregado() {
    $('.mensaje_producto_agregado').fadeOut('slow');
    $('.mensaje_ver_productos_seleccionados').fadeIn('slow');
}

function seleccionar_producto(id) {
    $('#producto_seleccionado').val(id);
    
}

function eliminar_producto(id) {
    // var id = $('#producto_seleccionado').val();
    var base_url = $('#base_url').val();
    var experimento_id = $('#id').val();
    var url = base_url + 'experimento/eliminarProducto';
    $.ajax({
          type: "POST",
          url: url,
          data: {id: id, experimento_id: experimento_id},
          cache: false,
          success: function(html){
            busqueda_productos();
            $('body').removeClass('modal-open');
            $('#productos_por_experimento').html(html);
            $('.mensaje_producto_eliminado').fadeIn('slow');
            setTimeout('ocultar_mensaje_producto_eliminado()', 2000);
            var cant_productos = $('#productos_por_experimento #cant_productos').val();
            if (cant_productos == 0) {
                $('#productos_por_experimento .mensaje_sin_productos').fadeIn();
            }
          }
    });
}

function ocultar_mensaje_producto_eliminado() {
    $('.mensaje_producto_eliminado').fadeOut('slow');
}

function validar_productos() {
    var cant_productos = $('#cant_productos').val();
    var base_url = $('#base_url').val();
    var experimento_id = $('#id').val();
    if (cant_productos > 0) {
        location.href = base_url+'experimento/productosConfirm/'+experimento_id;
    }
    else {
        var error = 'Debe agregar productos al experimento para continuar.';
        $('#error_message #message').html(error);
        $('#error_message').fadeIn();
    }
}

function seleccionar_producto_busqueda(id) {
    if ($('#check_search_'+id).is(':checked') ) {
        $('.busqueda_productos #row'+id).addClass('selected');
    }
    else {
        $('.busqueda_productos #row'+id).removeClass('selected');
    }
}

function agregar_multiples_productos() {
    var productos = [];
    var producto = {};
    var cantidad = 0;
    var disponible = 0;
    var serie = 0;
    var error = false;
    $('#busqueda_productos .listado tr.selected').each(function() {
        if (!error) {
            var id = $(this).attr('id');
            id = id.replace("row", "");

            $('.error_seleccion_multiple').addClass('hidden');
            cantidad = parseInt($('#cantidad_'+id).val());
            if (!cantidad) cantidad = 0;
            disponible = $('#disponible_'+id).val();
            
            serie = 0;
            if ($('#usa_serie_'+id).is(':checked'))
                serie = 1;
            
            error = false;
            if (cantidad == 0) {
                error = true;
            }
            if (cantidad > disponible) {
                error = true;
            }

            producto = {id_producto: id, cantidad: cantidad, serie: serie, disponible: disponible};
            productos.push(producto);
        }
    });
    
    if (error) {
        alert('ERROR CANTIDAD');
        productos = [];
        $('.error_seleccion_multiple').removeClass('hidden');
    }
    else {
        var base_url = $('#base_url').val();
        var experimento_id = $('#id').val();
        var url = base_url + 'experimento/agregarMultiplesProductos';
        $.ajax({
                type: "POST",
                url: url,
                data: {experimento_id: experimento_id, productos: productos},
                cache: false,
                success: function(html){
                    alert('OK');
                }
        });
    }
}

/* ------------------ CARGAR SERIES ----------------- */

function validar_series() {
    var sin_productos = $('#sin_productos').val();
    var productos_sin_series = $('#productos_sin_series').val();
    var base_url = $('#base_url').val();
    var experimento_id = $('#id').val();

    if (sin_productos == 1) {
        // Error. No se han cargado productos
        var error = 'Debe agregar productos al experimento para continuar.';
        $('#error_message #message').html(error);
        $('#error_message').fadeIn();
    }
    else {
        if (productos_sin_series == 1) {
            // Los productos no tienen series, continuar al siguiente paso
            location.href = base_url+'experimento/agregarEquipos/'+experimento_id;
        }
        else {
            // Validación de series
            var status = 0;
            $('.series_status').each(function() {
                status = parseInt(status) + parseInt($(this).val());
            });
            if (status > 0) {
                var error = 'Debe asignar todas las series para poder continuar.';
                $('#error_message #message').html(error);
                $('#error_message').fadeIn();
            }
            else {
                $('#experimento-series-form').submit();
            }
        }
    }
}

/* ------------------ AGREGAR EQUIPOS ----------------- */

// Función para cargar el listado de equipos asociados al experimento
function cargarEquiposPorExperimento(id) {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/equiposPorExperimento/'+id;
    $.ajax({
          type: "POST",
          url: url,
          cache: false,
          success: function(html){
            $('#equipos_por_experimento').html(html);
            var cant_equipos = $('#equipos_por_experimento #cant_equipos').val();
            if (cant_equipos == 0) {
                $('#equipos_por_experimento .mensaje_equipo_agregado').fadeIn();
            }
          }
    });
}

function buscarEquipos(e) {
    if (!e.isDefaultPrevented()) {
        e.preventDefault();
        busqueda_equipos();
    }
}

function busqueda_equipos() {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/buscarEquipos';
    $.ajax({
          type: "POST",
          url: url,
          data: $('#buscar-equipos-form').serialize(),
          cache: false,
          success: function(html){
            $('#busqueda_equipos').html(html);
          }
    });
}

function agregar_equipo(id) {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/agregarEquipo';
    var experimento_id = $('#id').val();
    $.ajax({
          type: "POST",
          url: url,
          data: {id: id, experimento_id: experimento_id},
          cache: false,
          success: function(html){
                $('#btn_agregar_equipo_'+id).addClass('hidden');
                $('#btn_equipo_agregado_'+id).removeClass('hidden');
                $('#row'+id).addClass('selected');
                $('#error_message').fadeOut();
                $('#equipos_por_experimento').html(html);
                $('.mensaje_equipo_agregado').fadeIn('slow');
                setTimeout('ocultar_mensaje_equipo_agregado()', 2000);
          }
    });
}

function ocultar_mensaje_equipo_agregado() {
    $('.mensaje_equipo_agregado').fadeOut('slow');
    $('.mensaje_ver_equipos_seleccionados').fadeIn('slow');
}

function seleccionar_equipo(id) {
    $('#equipo_seleccionado').val(id);
}

function eliminar_equipo(id) {
    // var id = $('#equipo_seleccionado').val();
    var base_url = $('#base_url').val();
    var experimento_id = $('#id').val();
    var url = base_url + 'experimento/eliminarEquipo';
    $.ajax({
          type: "POST",
          url: url,
          data: {id: id, experimento_id: experimento_id},
          cache: false,
          success: function(html){
            $('#equipos_por_experimento').html(html);
            busqueda_equipos();
            $('.mensaje_equipo_eliminado').fadeIn('slow');
            setTimeout('ocultar_mensaje_equipo_eliminado()', 2000);
            var cant_equipos = $('#equipos_por_experimento #cant_equipos').val();
            if (cant_equipos == 0) {
                $('#equipos_por_experimento .mensaje_equipo_agregado').fadeIn();
            }
          }
    });
}

function ocultar_mensaje_equipo_eliminado() {
    $('.mensaje_equipo_eliminado').fadeOut('slow');
}

function validar_equipos() {
    var cant_equipos = $('#cant_equipos').val();
    var base_url = $('#base_url').val();
    var experimento_id = $('#id').val();
    if (cant_equipos > 0) {
        location.href = base_url+'experimento/equiposConfirm/'+experimento_id;
    }
    else {
        var error = 'Debe agregar equipos al experimento para continuar.';
        $('#error_message #message').html(error);
        $('#error_message').fadeIn();
    }
}

function cambiar_estado() {
    var base_url = $('#base_url').val();
    var experimento_id = $('#id').val();
    var url = base_url + 'experimento/cambiarEstado/0';
    $.ajax({
        type: "POST",
        url: url,
        data: {experimento_id: experimento_id},
        cache: false,
        success: function(){
            location.href = base_url+'experimento/cambiarEstadoConfirm/'+experimento_id;
        }
    });
}

function agregar_info_adicional() {
    $('#error_message').hide();
    var error = '';

    // Campo Más Información
    if (error == '') {
        var informacion = CKEDITOR.instances.Experimento_informacion.getData();
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
        var experimento_id = $('#experimento_id').val();
        var url = base_url + 'experimento/agregarInformacionAdicional';
        $.ajax({
            type: "POST",
            url: url,
            data: {experimento_id: experimento_id, informacion: informacion},
            cache: false,
            success: function(){
                recargar_listado_info_adicional();
                CKEDITOR.instances.Experimento_informacion.setData('');
                $('#modal_mas_info_ok').modal('show');
            }
        });
    }
}

function editar_info_adicional_form(id) {
    $('.info_adicional_experimento tr').removeClass('selected');
    $('#row'+id).addClass('selected');
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/editarInformacionAdicionalForm';
    $.ajax({
        type: "POST",
        url: url,
        data: {estado_id: id},
        cache: false,
        success: function(html){
            CKEDITOR.instances.Experimento_editar_informacion.setData(html);
            $('#estado_id').val(id);
            $('#editar_info_wrapper').slideDown('slow');
            goto('editar_info_wrapper', 1);
        }
    });
}

function editar_info_adicional() {
    $('#error_message_edit').hide();
    var error = '';

    // Campo Más Información
    if (error == '') {
        var informacion = CKEDITOR.instances.Experimento_editar_informacion.getData();
        if (informacion.trim().length == 0) {
            error = 'Debe ingresar información.';
        }
    }
    if (error != '') {
        $('#error_message_edit #message').html(error);
        $('#error_message_edit').fadeIn();
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
    $('.info_adicional_experimento tr').removeClass('selected');
    $('#estado_id').val(0);
    $('#editar_info_wrapper').slideUp('slow');
    CKEDITOR.instances.Experimento_editar_informacion.setData('');
    goto('titulo_listado', 1);
}

function recargar_listado_info_adicional() {
    var base_url = $('#base_url').val();
    var experimento_id = $('#experimento_id').val();
    var url = base_url + 'experimento/listadoInformacionAdicional';
    $.ajax({
        type: "POST",
        url: url,
        data: {experimento_id: experimento_id},
        cache: false,
        success: function(html){
            $('#listado_informacion_adicional').html(html);
        }
    });
}

function confirmar_eliminar(id) {
    $('#estado_id').val(id);
    $('#confirmar_eliminar').modal('show');
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

function confirmar_eliminar_experimento(id) {
    $('#experimento_seleccionado').val(id);
    $('#confirmar_eliminar_experimento').modal('show');
}

function eliminar_experimento() {
    var experimento_id = $('#experimento_seleccionado').val();
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/eliminarExperimento';
    $.ajax({
        type: "POST",
        url: url,
        data: {experimento_id: experimento_id},
        cache: false,
        success: function(){
            recargar_resumen_experimentos();
            recargar_listado_experimentos();
        }
    });
}

function recargar_listado_experimentos() {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/listadoExperimentos';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#listado_experimentos').html(html);
        }
    });
}

function recargar_resumen_experimentos() {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/resumenExperimentos';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#resumen_experimentos').html(html);
        }
    });
}

function show_advanced_search() {
    $('#advanced_search').slideDown();
    $('#listado_experimentos .dataTables_filter').fadeOut();
    $('#btn_show_advanced_search').fadeOut();
    $('#listado_experimentos .dataTables_filter input').val('');
}

function hide_advanced_search() {
    $("#advanced_search_form").get(0).reset();
    recargar_listado_experimentos();
    
    $('#advanced_search').slideUp();
    $('#listado_experimentos .dataTables_filter').fadeIn();
    $('#btn_show_advanced_search').fadeIn();
}

function advanced_search() {
    var base_url = $('#base_url').val();
    var url = base_url + 'experimento/busquedaAvanzada';
    $.ajax({
        type: "POST",
        url: url,
        data: $('#advanced_search_form').serialize(),
        cache: false,
        success: function(html){
            goto('listado_experimentos', 1);
            $('#listado_experimentos').html(html);
        }
    });
}

function load_advanced_search_datepickers() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
}

function borrar_datepicker(id) {
    $('#'+id).val('');
}