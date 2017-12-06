<?php
$this->breadcrumbs=array(
	'Producto Detalles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductoDetalle','url'=>array('index')),
	array('label'=>'Manage ProductoDetalle','url'=>array('admin')),
);
?>

<h1>Create ProductoDetalle</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>