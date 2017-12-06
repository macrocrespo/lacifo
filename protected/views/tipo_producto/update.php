<?php
$this->breadcrumbs=array(
	'Tipo Productos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TipoProducto','url'=>array('index')),
	array('label'=>'Create TipoProducto','url'=>array('create')),
	array('label'=>'View TipoProducto','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TipoProducto','url'=>array('admin')),
);
?>

<h1>Update TipoProducto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>