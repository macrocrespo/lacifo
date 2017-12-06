<?php if (count($data['tareas']) > 0) { ?>
<div class="task-content">
    <ul class="task-list">
        <?php foreach ($data['tareas'] as $r) { 
            $r          = (object) $r;
            $class      = ($r->estado) ? '' : 'task-done';
            $checked    = ($r->estado) ? '' : 'checked="checked"'; 
            $ampliar    = ($r->estado) ? '' : 'style="display: none;"'; ?>
        <li id="tarea_<?php echo $r->id; ?>" class="<?php echo $class; ?>">
            <div class="task-checkbox">
                <input <?php echo $checked; ?> tarea="<?php echo $r->id; ?>" onClick="tarea_realizada(this);" title="Tarea realizada" type="checkbox" class="list-child" value=""  />
            </div>
            <div class="task-title">
                <span class="task-title-sp"><?php echo $r->titulo; ?></span>
                <div class="asignado_por pull-left italic text-warning" style="font-size: 12px;">Asignado por <?php echo $r->asignado_por; ?>.</div>
                <div class="pull-right">
                    <button <?php echo $ampliar; ?> id="ampliar_tarea<?php echo $r->id; ?>" onclick="ampliar_tarea(<?php echo $r->id; ?>);" title="Ampliar" class="btn btn-primary btn-xs"><i class="icon-zoom-in"></i></button>
                    <button onclick="confirmar_eliminar_tarea(<?php echo $r->id; ?>);" title="Eliminar" class="btn btn-danger btn-xs m-right10"><i class="icon-trash "></i></button>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>

<div id="sin_tareas" style="display: none;">
    <?php $this->widget('Mensaje', array(
        'mensaje'   => 'No tiene tareas asignadas.',
        'type'      => 'success',
        'show_icon' => true,
        'close'     => false
    )); ?>
    
    <div class=" add-task-row">
        <a class="btn btn-success btn-sm pull-left" href="<?php echo Yii::app()->request->baseUrl; ?>/tarea"><i class="icon-plus-sign-alt"></i> Crear nueva tarea</a>
    </div>
</div>

<div id="ver_tareas" class=" add-task-row">
    <a class="btn btn-success btn-sm pull-left" href="<?php echo Yii::app()->request->baseUrl; ?>/tarea"><i class="icon-check"></i> Ver todas las tareas</a>
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

<script>
$(document).ready(function() {
    $('input.list-child').change(function() {
        var tarea_id = $(this).attr('tarea');
        if ($(this).is(':checked')) {
            $(this).parents('li').addClass("task-done");
            $('#ampliar_tarea'+tarea_id).fadeOut();
        } else { 
            $(this).parents('li').removeClass("task-done");
            $('#ampliar_tarea'+tarea_id).fadeIn();
        }
    }); 
});
</script>
<?php } else { 
    $this->widget('Mensaje', array(
        'mensaje'   => 'No tiene tareas asignadas.',
        'type'      => 'success',
        'show_icon' => true,
        'close'     => false
    )); ?>
    
    <div class=" add-task-row">
        <a class="btn btn-success btn-sm pull-left" href="<?php echo Yii::app()->request->baseUrl; ?>/tarea"><i class="icon-plus-sign-alt"></i> Crear nueva tarea</a>
    </div>

<?php } ?>