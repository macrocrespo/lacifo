<?php
$this->breadcrumbs=array(
	'Depositos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Deposito','url'=>array('index')),
	array('label'=>'Create Deposito','url'=>array('create')),
	array('label'=>'Update Deposito','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Deposito','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Deposito','url'=>array('admin')),
);
?>

<h1>View Deposito #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'descripcion',
		'direccion',
		'telefono',
		'estado',
	),
)); ?>
