<?php
$this->breadcrumbs=array(
	'Contenedors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Contenedor','url'=>array('index')),
	array('label'=>'Manage Contenedor','url'=>array('admin')),
);
?>

<h1>Create Contenedor</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>