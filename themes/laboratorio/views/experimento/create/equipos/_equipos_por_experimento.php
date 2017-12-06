<input type="hidden" id="cant_equipos" value="<?php echo count($equipos); ?>" />
<?php if (count($equipos) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado equipos_por_experimento">
        <thead>
        <tr>
            <th>Nombre</th>
            <th class="hidden-xs center">Marca</th>
            <th class="hidden-xs ">Observaciones</th>
            <th class="center">Estado</th>
            <th class="center min-width">Eliminar</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($equipos as $e) { $e = (object) $e; ?>
            <tr id="row<?php echo $e->id; ?>">
                <td>
                    <?php echo $e->nombre; ?>
                    <?php $marca_txt = ($e->marca != '') ? 'Marca: '.$e->marca.'. ' : ''; ?>
                    <i style="margin-top: 2px; display: inline-block;" title="<?php echo $marca_txt.$e->observaciones; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-info-sign m-left5"></i>
                </td>
                <td class="hidden-xs center"><?php echo $e->marca; ?></td>
                <td class="hidden-xs "><?php echo $e->observaciones; ?></td>
                <td class="center"><?php echo $e->estado; ?></td>
                <td class="center">
                       <a <?php /* href="#confirmar_eliminar" data-toggle="modal" */ ?> onclick="eliminar_equipo(<?php echo $e->id; ?>)" title="Eliminar equipo" class="btn-xs m-right5 btn btn-danger">
                        <i class="icon-trash"></i> 
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<input type="hidden" id="equipo_seleccionado" value="0" />
<div class="modal fade" id="confirmar_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                ¿ Esta seguro que desea eliminar el equipo del experimento ?
                <br ><br />
                Luego de la eliminación puede volver a agregar el equipo desde la búsqueda de equipos.
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-danger" onclick="eliminar_equipo();" type="button">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.equipos_por_experimento').dataTable({
        "bPaginate": true,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 4 ] }]
    });
});
</script>
<?php } else { ?>
    <?php $this->widget('Mensaje_listado', array(
        'mensaje'   => 'No hay equipos agregados al experimento. Para buscar y agregar equipos, <a style="cursor: pointer;" onclick="$(\'#tab2 a\').click();">click aquí</a>.',
        'class'     => 'mensaje_equipo_agregado pad-left0 pad-right0',
        'type'      => 'warning'
    )); ?>
<?php } ?>
