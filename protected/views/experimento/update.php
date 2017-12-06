<?php
$this->breadcrumbs=array(
	'Experimentos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Experimento','url'=>array('index')),
	array('label'=>'Create Experimento','url'=>array('create')),
	array('label'=>'View Experimento','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Experimento','url'=>array('admin')),
);
?>

<h1>Update Experimento <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>