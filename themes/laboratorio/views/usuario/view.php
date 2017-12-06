<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 'Detalle de '.$this->contenido), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel', array('title' => 'Detalle de '.$this->contenido, 'size'=>6)); ?>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
                array('name'=>'imagen', 'type'=>'raw', 
                    'value'=> CHtml::image(
                            $model->getImagen($model->imagen),
                            'Imagen',
                            array('class'=>'image_in_details'))
                    ),
		'id',
                array('name' => 'rol_id', 'value' => $model->rol->nombre),
		'nombre',
                'telefono_trabajo',
                'telefono_personal',
                'mail',
                array('name'=>'estado', 'value'=> $model->getNombreEstado($model->estado)),
	),
)); ?>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('../site/_view_opciones_generales', array('model'=>$model)); ?>