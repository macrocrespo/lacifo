<?php
$this->breadcrumbs=array(
	'Contenedors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Contenedor','url'=>array('index')),
	array('label'=>'Create Contenedor','url'=>array('create')),
	array('label'=>'View Contenedor','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Contenedor','url'=>array('admin')),
);
?>

<h1>Update Contenedor <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>