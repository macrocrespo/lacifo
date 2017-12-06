<?php
$this->breadcrumbs=array(
	'Permiso Rols'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PermisoRol','url'=>array('index')),
	array('label'=>'Create PermisoRol','url'=>array('create')),
	array('label'=>'Update PermisoRol','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PermisoRol','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PermisoRol','url'=>array('admin')),
);
?>

<h1>View PermisoRol #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'seccion_id',
		'rol_id',
	),
)); ?>
