<?php
$this->breadcrumbs=array(
	'Stocks',
);

$this->menu=array(
	array('label'=>'Create Stock','url'=>array('create')),
	array('label'=>'Manage Stock','url'=>array('admin')),
);
?>

<h1>Stocks</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
