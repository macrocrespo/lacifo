$(document).ready(function(){    
    var idView = $('#idView').val();
    switch (idView) {
        case 'detalles':
            var tipo = $('#tipo').val();
            listado_productos(tipo);
            break;
    }
});

function listado_productos(controller) {
    var base_url = $('#base_url').val();
    var id = $('#id').val();
    var url = base_url + controller + '/listadoProductos';
    $.ajax({
        type: "POST",
        url: url,
        data: {id: id},
        cache: false,
        success: function(html){
            $('#listado_productos').html(html);
        }
    });
}