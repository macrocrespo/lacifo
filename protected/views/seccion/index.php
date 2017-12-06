<?php
$this->breadcrumbs=array(
	'Seccions',
);

$this->menu=array(
	array('label'=>'Create Seccion','url'=>array('create')),
	array('label'=>'Manage Seccion','url'=>array('admin')),
);
?>

<h1>Seccions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
