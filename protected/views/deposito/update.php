<?php
$this->breadcrumbs=array(
	'Depositos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Deposito','url'=>array('index')),
	array('label'=>'Create Deposito','url'=>array('create')),
	array('label'=>'View Deposito','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Deposito','url'=>array('admin')),
);
?>

<h1>Update Deposito <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>