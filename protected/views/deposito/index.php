<?php
$this->breadcrumbs=array(
	'Depositos',
);

$this->menu=array(
	array('label'=>'Create Deposito','url'=>array('create')),
	array('label'=>'Manage Deposito','url'=>array('admin')),
);
?>

<h1>Depositos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
