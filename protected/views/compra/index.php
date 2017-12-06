<?php
$this->breadcrumbs=array(
	'Compras',
);

$this->menu=array(
	array('label'=>'Create Compra','url'=>array('create')),
	array('label'=>'Manage Compra','url'=>array('admin')),
);
?>

<h1>Compras</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
