<?php
$this->breadcrumbs=array(
	'Temp Compras'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TempCompra','url'=>array('index')),
	array('label'=>'Create TempCompra','url'=>array('create')),
	array('label'=>'View TempCompra','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TempCompra','url'=>array('admin')),
);
?>

<h1>Update TempCompra <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>