<?php
$this->breadcrumbs=array(
	'Tipo Productos',
);

$this->menu=array(
	array('label'=>'Create TipoProducto','url'=>array('create')),
	array('label'=>'Manage TipoProducto','url'=>array('admin')),
);
?>

<h1>Tipo Productos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
