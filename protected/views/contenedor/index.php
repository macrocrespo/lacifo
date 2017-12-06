<?php
$this->breadcrumbs=array(
	'Contenedors',
);

$this->menu=array(
	array('label'=>'Create Contenedor','url'=>array('create')),
	array('label'=>'Manage Contenedor','url'=>array('admin')),
);
?>

<h1>Contenedors</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
