<?php
$this->breadcrumbs=array(
	'Experimentos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Experimento','url'=>array('index')),
	array('label'=>'Create Experimento','url'=>array('create')),
	array('label'=>'Update Experimento','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Experimento','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Experimento','url'=>array('admin')),
);
?>

<h1>View Experimento #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'usuario_id',
		'consumidor_id',
		'fecha',
		'titulo',
		'descripcion',
		'condiciones',
		'resultados',
		'total',
	),
)); ?>
