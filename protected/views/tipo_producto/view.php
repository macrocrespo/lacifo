<?php
$this->breadcrumbs=array(
	'Tipo Productos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TipoProducto','url'=>array('index')),
	array('label'=>'Create TipoProducto','url'=>array('create')),
	array('label'=>'Update TipoProducto','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TipoProducto','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoProducto','url'=>array('admin')),
);
?>

<h1>View TipoProducto #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'rubro_id',
		'nombre',
		'descripcion',
		'inicial',
		'estado',
	),
)); ?>
