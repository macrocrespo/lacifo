<?php
$this->breadcrumbs=array(
	'Producto Detalles',
);

$this->menu=array(
	array('label'=>'Create ProductoDetalle','url'=>array('create')),
	array('label'=>'Manage ProductoDetalle','url'=>array('admin')),
);
?>

<h1>Producto Detalles</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
