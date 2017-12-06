<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 'Detalle de '.$this->contenido), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel', array('title' => 'Detalle del '.$this->contenido, 'size'=>6)); ?>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
                'direccion',
                'telefono',
                'mail',
                'web',
	),
)); ?>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('../site/_view_opciones_generales', array('model'=>$model)); ?>