<?php
$this->breadcrumbs=array(
	'Experimentos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Experimento','url'=>array('index')),
	array('label'=>'Manage Experimento','url'=>array('admin')),
);
?>

<h1>Create Experimento</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>