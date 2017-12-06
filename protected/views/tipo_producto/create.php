<?php
$this->breadcrumbs=array(
	'Tipo Productos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TipoProducto','url'=>array('index')),
	array('label'=>'Manage TipoProducto','url'=>array('admin')),
);
?>

<h1>Create TipoProducto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>