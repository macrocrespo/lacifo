<?php
$this->breadcrumbs=array(
	'Temp Compras'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TempCompra','url'=>array('index')),
	array('label'=>'Manage TempCompra','url'=>array('admin')),
);
?>

<h1>Create TempCompra</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>