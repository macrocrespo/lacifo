<?php
$this->breadcrumbs=array(
	'Depositos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Deposito','url'=>array('index')),
	array('label'=>'Manage Deposito','url'=>array('admin')),
);
?>

<h1>Create Deposito</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>