<?php if (count($equipos) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado busqueda_equipos">
        <thead>
        <tr>
            <th>Nombre</th>
            <th class="hidden-xs center">Marca</th>
            <th class="hidden-xs ">Observaciones</th>
            <th class="center">Estado</th>
            <th class="center min-width">
                <span class="no-phone">Agregar</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($equipos as $e) { $e = (object) $e; ?>
        <tr id="row<?php echo $e->id; ?>" <?php if (in_array($e->id, $seleccionados)) { echo 'class="selected"'; } ?>>
            <td>
                <?php echo $e->nombre; ?>
                <?php $marca_txt = ($e->marca != '') ? 'Marca: '.$e->marca.'. ' : ''; ?>
                <i style="margin-top: 2px; display: inline-block;" title="<?php echo $marca_txt.$e->observaciones; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-info-sign m-left5"></i>
            </td>
            <td class="hidden-xs center"><?php echo $e->marca; ?></td>
            <td class="hidden-xs "><?php echo $e->observaciones; ?></td>
            <td class="center"><?php echo $e->estado; ?></td>
            <td class="center">
                <?php if (!in_array($e->id, $seleccionados)) { ?>
                <a id="btn_agregar_equipo_<?php echo $e->id; ?>" onclick="agregar_equipo(<?php echo $e->id; ?>)" title="Agregar equipo" class="btn-xs m-right5 btn btn-success">
                    <i class="icon-plus-sign-alt"></i> 
                </a>
                <a id="btn_equipo_agregado_<?php echo $e->id; ?>" title="Este equipo ya se ha agregado al experimento" class="btn-xs m-right5 btn btn-warning hidden">
                    <i class="icon-plus-sign-alt"></i> 
                </a>
                <?php } else { ?>
                <a title="Este equipo ya se ha agregado al experimento" class="btn-xs m-right5 btn btn-warning">
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
    $('.busqueda_equipos').dataTable({
        "bPaginate": true,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 2,4 ] }]
    });
});
</script>
<?php } else {
    echo '<br>';
    $this->widget('Mensaje', array(
        'mensaje'   => 'No se han encontrado equipos.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));
} ?>
