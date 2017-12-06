<input type="hidden" id="cant_productos" value="<?php echo count($productos); ?>" />
<?php if (count($productos) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado productos_por_experimento">
        <thead>
        <tr>
            <th style="width: 80px;" class="no-mobile">Código</th>
            <th>Nombre</th>
            <th class="center no-mobile">Tipo</th>
            <th class="center no-mobile" style="width: 90px;">Usa serie</th>
            <th class="center">Cantidad</th>
            <th class="center min-width"><span class="no-phone">Eliminar</span></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $p) { $p = (object) $p; ?>
        <tr id="row<?php echo $p->id; ?>">
            <td class="no-mobile"><?php echo $p->id; ?></td>
            <td>
                <?php echo $p->nombre; ?>
                <?php $txt_serie = ($p->producto_usa_serie) ? '. Se deben cargar series.' : ''; ?>
                <i style="margin-top: 2px; display: inline-block;" title="Código: <?php echo $p->id; ?>. Tipo: <?php echo $p->tipo.$txt_serie; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-info-sign m-left5"></i>
            </td>
            <td class="center no-mobile"><?php echo $p->tipo; ?></td>
            <td class="center no-mobile">
                <?php if($p->producto_usa_serie) { ?>
                <span class="hidden">a</span>
                <i title="Este producto carga series" class="icon-ok-sign text-success" style="font-size: 18px;"></i>
                <?php } else { ?>
                <span class="hidden">b</span>
                <i title="Este producto no carga series" class="icon-minus-sign text-default" style="font-size: 18px;"></i>
                <?php } ?>
            </td>
            <td class="center"><?php echo $p->cantidad; ?>
                <?php if ($p->fraccion != '') { ?>
                x <?php echo $p->fraccion; ?><?php echo $p->unidad_medida; ?>
                <?php } ?>
            </td>
            <td class="center">
                <a <?php /* href="#confirmar_eliminar" data-toggle="modal" */ ?> onclick="eliminar_producto(<?php echo $p->id; ?>)" title="Eliminar producto" class="btn-xs m-right5 btn btn-danger">
                    <i class="icon-trash"></i> 
                </a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<input type="hidden" id="producto_seleccionado" value="0" />
<div class="modal fade" id="confirmar_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                ¿ Esta seguro que desea eliminar el producto del experimento ?
                <br ><br />
                Luego de la eliminación puede volver a agregar el producto desde la búsqueda de productos.
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-danger" onclick="eliminar_producto();" type="button">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.productos_por_experimento').dataTable({
        "bPaginate": true,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 4,5 ] }]
    });
});
</script>
<?php } else {
    $this->widget('Mensaje_listado', array(
        'mensaje'   => 'No hay productos agregados al experimento. Para buscar y agregar productos, <a style="cursor: pointer;" onclick="$(\'#tab2 a\').click();">click aquí</a>.',
        'class'     => 'mensaje_sin_productos pad-left0 pad-right0',
        'type'      => 'warning'
    ));
    echo '<br>';
} ?>
