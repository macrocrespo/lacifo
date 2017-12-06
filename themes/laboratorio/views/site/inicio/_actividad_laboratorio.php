<?php 
/* Actividad del laboratorio (view)
 * Panel que muestra la actividad reciente del laboratorio
 */
?>
<div class="task-content">
    <ul class="task-list">
        <?php foreach ($data['logs'] as $log) { $log = (object) $log; ?>
        <li id="tarea_<?php echo $log->id; ?>">
            <div class="task-checkbox">
                <button title="<?php echo $log->accion_txt.' '.$log->tooltip; ?>" style="cursor: default;" class="btn <?php echo str_replace('text', 'btn', $log->color_icono) ; ?> btn-xs">
                    <i class="<?php echo $log->icono; ?>"></i>
                    <br><i class="<?php echo $log->tipo_icono; ?>"></i>
                </button>
            </div>
            <div class="task-title">
                <span class="task-title-sp">
                    <?php if ($log->descripcion != '') echo $log->descripcion; 
                          else echo $log->accion_txt.' '.$log->tabla; ?>
                </span>
                <div class="asignado_por pull-left italic text-info" style="font-size: 12px;">
                    <i class="icon-time"></i> <?php echo $log->fecha_txt; ?> <i class="icon-user m-left10"></i> <?php echo $log->nombre_usuario; ?>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>