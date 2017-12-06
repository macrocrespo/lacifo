<?php if ($data['problemas_stock']) { ?>
<div class="col-lg-12">
    <?php $this->widget('Mensaje', array(
        'mensaje'   => 'Hay productos con problemas de stock. Por favor, revise las notificaciones haciendo <a class="alert-link" href="'.Yii::app()->request->baseUrl.'/notificacion">click aquí</a>.',
        'type'      => 'danger',
        'show_icon' => true,
        'close'     => true
    )); ?>
</div>
<?php } ?>

<div class="col-md-4 col-lg-4">
    
    <?php echo $this->renderPartial('inicio/_perfil_usuario', array('data'=>$data)); ?>

</div>

<?php $this->beginWidget('Panel', array('title' => 'Tareas', 'icon'=>'check', 'size'=>4, 'class'=>'tasks-widget')); ?>

    <div id="tareas_usuario" style="display: none;"></div>

<?php $this->endWidget(); ?>


<?php $this->beginWidget('Panel', array('title' => 'Actividad reciente', 'icon'=>'rss', 'size'=>4, 'class'=>'tasks-widget')); ?>

    <div id="actividad_laboratorio" style="display: none;"></div>

<?php $this->endWidget(); ?>