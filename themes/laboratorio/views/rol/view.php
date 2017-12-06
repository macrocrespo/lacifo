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
		'id',
		'nombre',
                'descripcion',
                'seguridad',
                array('name'=>'estado', 'value'=> $model->getNombreEstado($model->estado)),
	),
)); ?>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('../site/_view_opciones_generales', array('model'=>$model)); ?>

<?php $this->beginWidget('Panel', array('title' => 'Usuarios con este rol', 'min_option'=>true , 'size'=>6)); ?>

    <?php $this->widget('Tabla', array(
        'controller' => 'usuario',
        'model' => $usuarios,
        'columnas'=>array(
            array('name'=>'id',         'header'=>'ID'),
            array('name'=>'nombre',     'header'=>'Nombre de usuario'),
            array('name'=>'rol_id',     'header'=>'Rol', 'relation' => 'rol->nombre')),
        'acciones' => array('ver'=>true, 'editar'=>true),
    )); ?>

<?php $this->endWidget(); ?>