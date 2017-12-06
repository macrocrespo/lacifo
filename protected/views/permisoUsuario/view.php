<?php
$this->breadcrumbs=array(
	'Permiso Usuarios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PermisoUsuario','url'=>array('index')),
	array('label'=>'Create PermisoUsuario','url'=>array('create')),
	array('label'=>'Update PermisoUsuario','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PermisoUsuario','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PermisoUsuario','url'=>array('admin')),
);
?>

<h1>View PermisoUsuario #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'seccion_id',
		'usuario_id',
	),
)); ?>
