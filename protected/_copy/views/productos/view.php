<?php
$this->breadcrumbs=array(
	'Productoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Productos','url'=>array('index')),
	array('label'=>'Create Productos','url'=>array('create')),
	array('label'=>'Update Productos','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Productos','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Productos','url'=>array('admin')),
);
?>

<h1>View Productos #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'familia_id',
		'nombre',
		'nombre_adic',
		'costo',
		'habilita',
		'fecha_alta',
		'fecha_modi',
		'usuario_alta_id',
		'usuario_modi_id',
	),
)); ?>
