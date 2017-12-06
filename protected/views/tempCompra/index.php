<?php
$this->breadcrumbs=array(
	'Temp Compras',
);

$this->menu=array(
	array('label'=>'Create TempCompra','url'=>array('create')),
	array('label'=>'Manage TempCompra','url'=>array('admin')),
);
?>

<h1>Temp Compras</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
