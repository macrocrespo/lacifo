<?php if (count($data['tareas']) > 0) { ?>
<div class="adv-table m-top20">
    <table id="tareas_asignadas" class="display table table-bordered table-striped listado">
        <thead>
        <tr>
            <th class="center">
                <i title="Tarea realizada" class="text-success icon-check fsize150"></i>
            </th>
            <th>Titulo</th>
            <th class="hidden-xs">Asignada a</th>
            <th class="hidden-xs">Asignada por</th>
            <th class="hidden-xs center">Fecha</th>
            <th class="center">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['tareas'] as $tarea) { $tarea = (object) $tarea; ?>
        <tr id="row<?php echo $tarea->id; ?>" class="<?php echo $tarea->class; ?> <?php if ($tarea->asignada_a == 'Mi') { echo 'mi'; } ?>">
            <td class="center">
                <span class="hidden"><?php echo ($tarea->class != '') ? 'a' : 'b'; ?></span>
                <?php if ($tarea->asignada_a == 'Mi') { ?>
                <input <?php echo $tarea->checked; ?> tarea="<?php echo $tarea->id; ?>" onClick="tarea_realizada(this);" type="checkbox" value=""  />
                <?php } ?>
            </td>
            <td>
                <?php echo $tarea->titulo; ?>
                <div style="display: inline-block; float: right;">
                    <i title="Fecha: <?php echo $tarea->fecha_txt; ?>" class="only-mobile icon-time pull-right fsize125 title_in_modal "></i>
                    <i title="Asignada a <?php echo $tarea->asignada_a; ?>. Por <?php echo $tarea->asignada_por; ?>" class="only-mobile icon-user pull-right fsize125 title_in_modal "></i>
                </div>
            </td>
            <td class="hidden-xs"><?php echo $tarea->asignada_a; ?></td>
            <td class="hidden-xs"><?php echo $tarea->asignada_por; ?></td>
            <td class="hidden-xs center">
                <span class="hidden"><?php echo $tarea->fecha; ?></span>
                <?php echo $tarea->fecha_txt; ?>
            </td>
            <td class="center" style="min-width: 95px;">
                <a style="cursor: pointer;" onclick="ampliar_tarea(<?php echo $tarea->id; ?>);" class="btn btn-xs btn-info" title="Ampliar"><i class="icon-zoom-in"></i></a>
                <a style="cursor: pointer; margin-left: 2px;" onclick="goto('editar_tarea_wrapper', 1); editar_tarea_form(<?php echo $tarea->id; ?>);" class="btn btn-xs btn-warning" title="Editar"><i class="icon-pencil"></i></a>
                <a style="cursor: pointer; margin-left: 2px;" onclick="confirmar_eliminar(<?php echo $tarea->id; ?>);" class="btn btn-xs btn-danger" title="Eliminar"><i class="icon-trash"></i></a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modal_detalle_tarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-check"></i> Detalle de la tarea</h4>
            </div>
            <div class="modal-body">
                <?php foreach ($data['tareas'] as $r) { $r = (object) $r; ?>
                <div class="detalle_tarea" id="detalle_tarea_<?php echo $r->id; ?>" style="display: none;">
                    <strong class="m-bot10" style="display: block; font-size: 14px;"><?php echo $r->titulo; ?></strong>
                    <p><?php echo $r->descripcion; ?></p>
                </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="tarea_seleccionada" value="" />
<div class="modal fade" id="modal_eliminar_tarea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-trash"></i> Eliminar tarea</h4>
            </div>
            <div class="modal-body">
                ¿ Seguro que desea eliminar la tarea ?
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-danger" onclick="eliminar_tarea();" type="button">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<?php $theme_url = Yii::app()->theme->baseUrl.'/'; ?>
<script type="text/javascript" language="javascript" src="<?php echo $theme_url; ?>assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(document).ready(function() {
        $('.listado').dataTable({
            "bPaginate": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": false,
            "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 5 ] }]
        });
    });
});
</script>

<?php } else {
    $this->widget('Mensaje', array(
        'mensaje'   => 'No tienes tareas asignadas.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));
} ?>