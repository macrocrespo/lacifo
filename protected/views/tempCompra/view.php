<?php
$this->breadcrumbs=array(
	'Temp Compras'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TempCompra','url'=>array('index')),
	array('label'=>'Create TempCompra','url'=>array('create')),
	array('label'=>'Update TempCompra','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TempCompra','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TempCompra','url'=>array('admin')),
);
?>

<h1>View TempCompra #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'total',
		'observacion',
		'estado',
		'usuario_id',
		'proveedor_id',
	),
)); ?>
