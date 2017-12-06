var base_url = $('#base_url').val();
$(document).ready(function(){
    $('#producto-form').submit(function(e){
        validarProducto(e);
    });
    
    var idView = $('#idView').val();
    switch (idView) {
        case 'admin':
            recargar_listado_productos();
            break;
        case 'detalles':
            listado_experimentos();
            break;
    }
    
    habilitar_detalle(1);
    
    $('#Producto_rubro').change(function(){
        var rubro = $(this).val();
        $.ajax({
            url: base_url+'producto/select_tipo_producto_por_rubro',
            data: {rubro: rubro},
            type: 'POST',
            success: function(html){
                $('#tipo_producto_id .col-sm-8').html(html);
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
                $('#contenedor_id .col-sm-8').html(html);
            }
        });
    });
});

// Función para validar el formulario de productos
function validarProducto(e) {
    if (!e.isDefaultPrevented()) {
        $('#error_message').hide();
        var error = '';
        var tipo = '';
        var focus = '';
        // Título
        var titulo = $.trim($('#Producto_nombre').val());
        if (titulo.length == 0) {
            $('#tab1 a').click();
            error = '<i class="icon-warning-sign"></i> Debe ingresar el nombre.';
            tipo = 'Producto';
            focus = 'nombre';
        }
        // Descripción
        if (error == '') {
            var descripcion = $.trim($('#Producto_descripcion').val());
            if (descripcion.length == 0) {
                $('#tab1 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar la descripción.';
                tipo = 'Producto';
                focus = 'descripcion';
            } 
        }
        // Marca
        if (error == '') {
            var marca = $.trim($('#Producto_marca').val());
            if (marca.length == 0) {
                $('#tab1 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar la marca.';
                tipo = 'Producto';
                focus = 'marca';
            } 
        }
        // Rubro
        if (error == '') {
            var rubro = $.trim($('#Producto_rubro').val());
            if (rubro.length == 0) {
                $('#tab2 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el rubro.';
                tipo = 'Producto';
                focus = 'rubro';
            } 
        }
        // Tipo de producto
        if (error == '') {
            var tipo = $.trim($('#Producto_tipo_producto_id').val());
            if (tipo.length == 0) {
                $('#tab2 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el tipo de producto.';
                tipo = 'Producto';
                focus = 'tipo_producto_id';
            } 
        }
        // Depósito
        if (error == '') {
            var deposito = $.trim($('#Producto_deposito').val());
            if (deposito.length == 0) {
                $('#tab2 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el depósito.';
                tipo = 'Producto';
                focus = 'deposito';
            } 
        }
        // Contenedor
        if (error == '') {
            var contenedor = $.trim($('#Producto_contenedor_id').val());
            if (contenedor.length == 0) {
                $('#tab2 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el contenedor.';
                tipo = 'Producto';
                focus = 'contenedor_id';
            } 
        }
        // IUPAC
        if (error == '') {
            var iupac = $.trim($('#Producto_IUPAC').val());
            if (iupac.length == 0) {
                $('#tab2 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el IUPAC #.';
                tipo = 'Producto';
                focus = 'IUPAC';
            } 
        }
        // Stock mínimo
        if (error == '') {
            var minimo = $.trim($('#Stock_minimo').val());
            if (minimo.length == 0) {
                $('#tab3 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el stock mínimo.';
                tipo = 'Stock';
                focus = 'minimo';
            } 
        }
        // Stock máximo
        if (error == '') {
            var maximo = $.trim($('#Stock_maximo').val());
            if (maximo.length == 0) {
                $('#tab3 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el stock máximo.';
                tipo = 'Stock';
                focus = 'maximo';
            } 
        }
        // Stock sugerido
        if (error == '') {
            var sugerido = $.trim($('#Stock_sugerido').val());
            if (sugerido.length == 0) {
                $('#tab3 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar el stock sugerido.';
                tipo = 'Stock';
                focus = 'sugerido';
            }
        }
        // Stock cantidad actual
        if (error == '') {
            var sugerido = $.trim($('#Stock_cantidad').val());
            if (sugerido.length == 0) {
                $('#tab3 a').click();
                error = '<i class="icon-warning-sign"></i> Debe ingresar la cantidad actual.';
                tipo = 'Stock';
                focus = 'cantidad';
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

function habilitar_detalle(get) {
    if($('#Producto_usa_detalle').is(':checked')) {
        $('#detalle input[type=text]').removeAttr('disabled');
        if (!get)
            $('#detalle input[type=text]').first().focus();
    }
    else {
        $('#detalle input[type=text]').attr('disabled', 'disabled');
    }
}

function recargar_listado_productos() {
    var base_url = $('#base_url').val();
    var url = base_url + 'producto/listadoProductos';
    $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(html){
            $('#listado_productos').html(html);
        }
    });
}

function confirmar_eliminar_producto(id) {
    var base_url = $('#base_url').val();
    var url = base_url + 'producto/validarEliminacion/'+id;
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        success: function(respuesta) {
            respuesta = parseInt(respuesta);
            if (respuesta == 1) { // Puede eliminar
               $('#producto_seleccionado').val(id);
                $('#confirmar_eliminar_producto').modal('show');
            }
            else {
                $('#mensaje_no_eliminar').modal('show');
            }
        }
    });
}

function eliminar_producto() {
    var producto_id = $('#producto_seleccionado').val();
    var base_url = $('#base_url').val();
    var url = base_url + 'producto/eliminarProducto';
    $.ajax({
        type: "POST",
        url: url,
        data: {producto_id: producto_id},
        cache: false,
        success: function(){
            recargar_listado_productos();
        }
    });
}

function listado_experimentos() {
    var base_url = $('#base_url').val();
    var producto_id = $('#producto_id').val();
    var url = base_url + 'producto/listadoExperimentosPorProducto';
    $.ajax({
        type: "POST",
        url: url,
        data: {producto_id: producto_id},
        cache: false,
        success: function(html){
            $('#listado_experimentos').html(html);
        }
    });
}