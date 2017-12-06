<?php
$this->breadcrumbs=array(
	'Contenedors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Contenedor','url'=>array('index')),
	array('label'=>'Create Contenedor','url'=>array('create')),
	array('label'=>'Update Contenedor','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Contenedor','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contenedor','url'=>array('admin')),
);
?>

<h1>View Contenedor #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'deposito_id',
		'nombre',
		'descripcion',
		'ubicacion',
		'estado',
	),
)); ?>
