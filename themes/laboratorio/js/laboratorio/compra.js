var base_url = $('#base_url').val();
$(document).ready(function(){
    productos_por_compra();
    /*
    habilitar_detalle(1);
    
    $('#Producto_rubro').change(function(){
        var rubro = $(this).val();
        $.ajax({
            url: base_url+'producto/select_tipo_producto_por_rubro',
            data: {rubro: rubro},
            type: 'POST',
            success: function(html){
                $('#tipo_producto_id .col-lg-8').html(html);
            }
        });
    });
    
    $('#Producto_deposito').change(function(){
        var deposito = $(this).val();
        $.ajax({
            url: base_url+'producto/select_contenedor_por_deposito',
            data: {deposito: deposito},
            type: 'POST',
            success: function(html){
                $('#contenedor_id .col-lg-8').html(html);
            }
        });
    });
    */
});

$(document).keyup(function (e) {
    if ($("#nombre_producto").is(":focus") && (e.keyCode === 13)) {
        buscar_productos();
    }
});

function ver_compra_details() {
    $('#panel_mensaje_wrapper').removeClass('col-lg-12');
    $('#panel_mensaje_wrapper').addClass('col-lg-6');
    $('#panel_info_compra_wrapper').show();
}

function ocultar_compra_details() {
    $('#panel_info_compra_wrapper').hide();
    $('#panel_mensaje_wrapper').removeClass('col-lg-6');
    $('#panel_mensaje_wrapper').addClass('col-lg-12');
}

function ver_agregar_producto() {
    $('#panel_productos_wrapper').removeClass('col-lg-12');
    $('#panel_productos_wrapper').addClass('col-lg-6');
    $('#panel_agregar_producto_wrapper').show();
}

function ocultar_agregar_producto() {
    $('#panel_agregar_producto_wrapper').hide();
    $('#panel_productos_wrapper').removeClass('col-lg-6');
    $('#panel_productos_wrapper').addClass('col-lg-12');
}

function buscar_productos() {
    var idCompra = $('#idCompra').val();
    var nombre = $('#nombre_producto').val();
    $.ajax({
        url: base_url+'compra/buscarProductos',
        data: {nombre: nombre, id: idCompra},
        type: 'POST',
        success: function(html){
            $('#productos_encontrados').html(html);
            $('.dataTables_wrapper .dataTables_length').remove();
            $('.dataTables_wrapper .dataTables_filter').remove();
            
            var ppc = $('#ppc').val();
            var i = 0;
            var len = ppc.length;
            for (i = 0; i < len; i++) {
                deshabilitar_button(ppc[i]);
                i++;
            }
        }
    });
}

function form_agregar_producto(button) {
    var id = $(button).parent().parent().attr('id');
    var nombre = $(button).parent().parent().children().eq(1).html();
    $('#agregar_producto_form #errors').hide();
    $('#agregar_producto_form #td_idProducto td').html(id);
    $('#agregar_producto_form #td_nombreProducto td').html(nombre);
    $('#agregar_producto_form #idProducto').val(id);
}

function agregar_producto() {
    $('#agregar_producto_form #errors').hide();
    var idProducto = $('#agregar_producto_form #idProducto').val();
    var idCompra = $('#idCompra').val();
    var costo = $('#agregar_producto_form #td_costoProducto input').val();
    var cantidad = parseInt($('#agregar_producto_form #td_cantidadProducto input').val());
    if (isNaN(costo) || costo <= 0) {
        $('#agregar_producto_form #errors p').html('El costo debe ser mayor a 0.');
        $('#agregar_producto_form #errors').fadeIn();
    }
    else {
        if (isNaN(cantidad) || cantidad <= 0) {
            $('#agregar_producto_form #errors p').html('La cantidad debe ser mayor a 0.');
            $('#agregar_producto_form #errors').fadeIn();
        }
        else {
            $.ajax({
                url: base_url+'compra/agregar_producto',
                data: {idProducto: idProducto, idCompra: idCompra, costo: costo, cantidad: cantidad},
                type: 'POST',
                success: function() {
                    $('#agregar_producto .btn-default').click();
                    deshabilitar_button(idProducto);
                    $('#agregar_producto_form #td_costoProducto input').val('');
                    $('#agregar_producto_form #td_cantidadProducto input').val(1);
                    productos_por_compra();
                }
            });
        }
    }
}

function deshabilitar_button(id) {
    var button = $('#productos_encontrados .dataTables_wrapper .listado tr#'+id+' a.btn');
    $(button).removeClass('btn-success');
    $(button).addClass('btn-default');
    $(button).removeAttr('onclick');
    $(button).removeAttr('href');
}

function productos_por_compra() {
    var idCompra = $('#idCompra').val();
    $.ajax({
        url: base_url+'compra/productos_por_compra',
        data: {id: idCompra},
        type: 'POST',
        success: function(html){
            $('#productos_por_compra_wrapper').html(html);
            $('.dataTables_wrapper .dataTables_length').remove();
            $('.dataTables_wrapper .dataTables_filter').remove();
            var total = parseInt($('#productos_por_compra_wrapper #total').val());
            if (total > 0)
                $('.form-actions .btn-success').attr('href', '#confirmar_compra');
            else
                $('.form-actions .btn-success').attr('href', '#sin_productos');
        }
    });
}

function form_editar_producto(button) {
    var id = $(button).parent().parent().attr('id');
    var nombre = $(button).parent().parent().children().eq(1).html();
    var costo = $(button).parent().parent().children().eq(2).html();
    var cantidad = $(button).parent().parent().children().eq(3).html();
    $('#editar_producto_form #errors').hide();
    $('#editar_producto_form #td_idProducto td').html(id);
    $('#editar_producto_form #td_nombreProducto td').html(nombre);
    $('#editar_producto_form #idProducto').val(id);
    $('#editar_producto_form #td_costoProducto input').val(costo);
    $('#editar_producto_form #td_cantidadProducto input').val(cantidad);
}

function form_eliminar_producto(button) {
    var id = $(button).parent().parent().attr('id');
    var nombre = $(button).parent().parent().children().eq(1).html();
    var costo = $(button).parent().parent().children().eq(2).html();
    var cantidad = $(button).parent().parent().children().eq(3).html();
    $('#eliminar_producto_form #errors').hide();
    $('#eliminar_producto_form #td_idProducto td').html(id);
    $('#eliminar_producto_form #td_nombreProducto td').html(nombre);
    $('#eliminar_producto_form #idProducto').val(id);
    $('#eliminar_producto_form #td_costoProducto td').html(costo);
    $('#eliminar_producto_form #td_cantidadProducto td').html(cantidad);
}

function form_cargar_series(button) {
    var idProducto = $(button).parent().parent().attr('id');
    var cantidad = parseInt($(button).parent().parent().children().eq(3).html());
    var idCompra = $('#idCompra').val();
    $('#cargar_series_form #errors').hide();
    $('#cargar_series_form #idProducto').val(idProducto);
    $('#cargar_series_form table').html('');
    $.ajax({
        url: base_url+'compra/cargar_tabla_series',
        data: {idProducto: idProducto, idCompra: idCompra, cantidad: cantidad},
        type: 'POST',
        success: function(html) {
            $('#cargar_series_form table').html(html);
        }
    });
}

function editar_producto() {
    $('#editar_producto_form #errors').hide();
    var idProducto = $('#editar_producto_form #idProducto').val();
    var idCompra = $('#idCompra').val();
    var costo = $('#editar_producto_form #td_costoProducto input').val();
    var cantidad = parseInt($('#editar_producto_form #td_cantidadProducto input').val());
    if (isNaN(costo) || costo <= 0) {
        $('#editar_producto_form #errors p').html('El costo debe ser mayor a 0.');
        $('#editar_producto_form #errors').fadeIn();
    }
    else {
        if (isNaN(cantidad) || cantidad <= 0) {
            $('#editar_producto_form #errors p').html('La cantidad debe ser mayor a 0.');
            $('#editar_producto_form #errors').fadeIn();
        }
        else {
            $.ajax({
                url: base_url+'compra/editar_producto',
                data: {idProducto: idProducto, idCompra: idCompra, costo: costo, cantidad: cantidad},
                type: 'POST',
                success: function() {
                    $('#editar_producto .btn-default').click();
                    $('#editar_producto_form #td_costoProducto input').val('');
                    $('#editar_producto_form #td_cantidadProducto input').val(1);
                    productos_por_compra();
                }
            });
        }
    }
}

function eliminar_producto() {
    $('#eliminar_producto_form #errors').hide();
    var idProducto = $('#eliminar_producto_form #idProducto').val();
    var idCompra = $('#idCompra').val();
    $.ajax({
        url: base_url+'compra/eliminar_producto',
        data: {idProducto: idProducto, idCompra: idCompra},
        type: 'POST',
        success: function() {
            $('#eliminar_producto .btn-default').click();
            productos_por_compra();
        }
    });
}

function cargar_series() {
    $('#cargar_series_form #errors').hide();
    var idProducto = $('#cargar_series_form #idProducto').val();
    var idCompra = $('#idCompra').val();
    var series = new Array();
    var sin_serie = false;
    var repetido = false;
    $('#cargar_series_form table input').each(function( index ) {
        if ($.inArray( $(this).val() , series ) >= 0) {
            repetido = true;
        }
        series[index] = $(this).val();
        if (series[index] === '')
            sin_serie = true;
    });
    if (sin_serie) {
        $('#cargar_series_form #errors p').html('Debe cargar todos los números de serie.');
        $('#cargar_series_form #errors').fadeIn();
    }
    else {
        if (repetido) {
            $('#cargar_series_form #errors p').html('Los números de serie deben ser distintos.');
            $('#cargar_series_form #errors').fadeIn();
        }
        else {
            $.ajax({
                url: base_url+'compra/cargar_series',
                data: {idProducto: idProducto, idCompra: idCompra, series: series},
                type: 'POST',
                success: function() {
                    $('#cargar_series .btn-default').click();
                }
            });
        }
    }
}