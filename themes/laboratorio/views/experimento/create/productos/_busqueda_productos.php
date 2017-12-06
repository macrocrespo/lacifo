<?php if (count($productos) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado busqueda_productos">
        <thead>
        <tr>
            <th style="width: 80px;" class="no-mobile">Código</th>
            <th>Nombre</th>
            <th class="center no-mobile">Tipo</th>
            <th class="center no-mobile" style="width: 90px;">Usa serie</th>
            <th style="width: 110px;">Cantidad</th>
            <th class="center min-width"><span class="no-phone">Agregar</span></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $p) { $p = (object) $p; ?>
        <tr id="row<?php echo $p->id; ?>" <?php if (in_array($p->id, $seleccionados)) {  echo 'class="selected"'; } ?>>
            <td class="no-mobile"><?php echo $p->id; ?></td>
            <td>
                <?php echo $p->nombre; ?>
                <?php $txt_serie = ($p->usa_serie) ? '. Se deben cargar series.' : ''; ?>
                <i style="margin-top: 2px; display: inline-block;" title="Código: <?php echo $p->id; ?>. Tipo: <?php echo $p->tipo.$txt_serie; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-info-sign m-left5"></i>
                <span title="Fracción: <?php echo $p->fraccion; ?> <?php echo $p->unidad_medida; ?>" class="fraccion_producto_listado">x <?php echo $p->fraccion; ?> <?php echo $p->unidad_medida; ?></span>
            </td>
            <td class="hidden-xs center no-phone"><?php echo $p->tipo; ?></td>
            <td class="center no-mobile">
                <?php if($p->usa_serie) { ?>
                <span class="hidden">a</span>
                <i title="Este producto carga series" class="icon-ok-sign text-success" style="font-size: 18px;"></i>
                <?php } else { ?>
                <span class="hidden">b</span>
                <i title="Este producto no carga series" class="icon-minus-sign text-default" style="font-size: 18px;"></i>
                <?php } ?>
            </td>
            <td>
                <input type="hidden" id="usa_serie_<?php echo $p->id; ?>" value="<?php echo $p->usa_serie; ?>" />
                <input style="display: inline;" <?php if (in_array($p->id, $seleccionados)) { echo 'disabled="disabled";'; }?> type="text" id="cantidad_<?php echo $p->id; ?>" class="form-control input-sm wxsmall" <?php if (in_array($p->id, $seleccionados)) { echo 'value="'.$cantidades[$p->id].'"'; } ?> />
                <span style="display: inline-block; margin-top: 2px;">&nbsp;de <?php echo $p->cantidad; ?></span>
            </td>
            <td class="center">
                <input type="hidden" id="disponible_<?php echo $p->id; ?>" value="<?php echo $p->cantidad; ?>" />
                <?php if (!in_array($p->id, $seleccionados)) { ?>
                <a id="btn_agregar_<?php echo $p->id; ?>" onclick="verificar_producto(<?php echo $p->id; ?>)" title="Agregar producto" class="btn-xs m-right5 btn btn-success">
                    <i class="icon-plus-sign-alt"></i> 
                </a>
                <?php /* Los errores se marcan en el INPUT
                <div id="error_cantidad_<?php echo $p->id; ?>" title="La cantidad no debe superar <?php echo $p->cantidad; ?>" class="btn-xs m-right5 btn btn-danger hidden error_icon">
                    <i class="icon-remove-sign"></i>
                </div>
                <div id="error_sin_cantidad_<?php echo $p->id; ?>" title="La cantidad debe ser superior a 0" class="btn-xs m-right5 btn btn-danger hidden error_icon">
                    <i class="icon-remove-sign"></i>
                </div>
                 * 
                 */ ?>
                <a id="btn_agregado_<?php echo $p->id; ?>" title="Este producto ya se ha agregado al experimento" class="btn-xs m-right5 btn btn-warning hidden">
                    <i class="icon-plus-sign-alt"></i> 
                </a>
                <?php } else { ?>
                <a title="Este producto ya se ha agregado al experimento" class="btn-xs m-right5 btn btn-warning">
                    <i class="icon-plus-sign-alt"></i> 
                </a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.busqueda_productos').dataTable({
        "bPaginate": true,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 4,5 ] }]
    });
});
</script>
<?php } else {
    echo '<br>';
    $this->widget('Mensaje', array(
        'mensaje'   => 'No se han encontrado productos.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));
} ?>
