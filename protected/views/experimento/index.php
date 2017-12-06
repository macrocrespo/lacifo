<?php
$this->breadcrumbs=array(
	'Experimentos',
);

$this->menu=array(
	array('label'=>'Create Experimento','url'=>array('create')),
	array('label'=>'Manage Experimento','url'=>array('admin')),
);
?>

<h1>Experimentos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
