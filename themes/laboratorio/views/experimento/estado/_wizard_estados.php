<h2 class="subtitle text-info">
    <i class="icon-double-angle-right"></i>
    <strong>Estados del experimento</strong>
</h2>

<?php 
$iniciado_class     = '';
$preparado_class    = '';
$en_curso_class     = '';
$finalizado_class   = '';
switch ($model->estado) {
    case 'INICIADO':    
        $iniciado_class     = 'active'; 
        break;
    case 'PREPARADO':
        $iniciado_class     = 'completed'; 
        $preparado_class    = 'active';
        break; 
    case 'EN_CURSO':
        $iniciado_class     = 'completed'; 
        $preparado_class    = 'completed';
        $en_curso_class     = 'active';
        break; 
    case 'FINALIZADO':
        $iniciado_class     = 'completed'; 
        $preparado_class    = 'completed';
        $en_curso_class     = 'completed';
        $finalizado_class   = 'active';
        break;
}
?>

<br>
<div class="col-lg-12 no-padding-mobile" style="margin-left: -15px; margin-right: -15px;">
    <ul class="progress-indicator">
        <li class="<?php echo $iniciado_class; ?> fsize125" title="Iniciado">
            <span class="bubble"></span>
            <i class="icon-home fsize150"></i>
            <t>Iniciado</t>
        </li>
        <li class="<?php echo $preparado_class; ?> fsize125" title="Preparado">
            <span class="bubble"></span>
            <i class="icon-puzzle-piece fsize150"></i>
            <t>Preparado</t>
        </li>
        <li class="<?php echo $en_curso_class; ?> fsize125" title="En curso">
            <span class="bubble"></span>
            <i class="icon-cog fsize150"></i>
            <t>En curso</t>
        </li>
        <li class="<?php echo $finalizado_class; ?> fsize125" title="Finalizado">
            <span class="bubble"></span>
            <i class="icon-flag fsize150"></i>
            <t>Finalizado</t>
        </li>
    </ul>
</div>
