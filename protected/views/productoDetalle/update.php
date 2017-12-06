<?php
$this->breadcrumbs=array(
	'Producto Detalles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductoDetalle','url'=>array('index')),
	array('label'=>'Create ProductoDetalle','url'=>array('create')),
	array('label'=>'View ProductoDetalle','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ProductoDetalle','url'=>array('admin')),
);
?>

<h1>Update ProductoDetalle <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>