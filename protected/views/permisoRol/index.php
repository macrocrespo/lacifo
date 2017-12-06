<?php
$this->breadcrumbs=array(
	'Permiso Rols',
);

$this->menu=array(
	array('label'=>'Create PermisoRol','url'=>array('create')),
	array('label'=>'Manage PermisoRol','url'=>array('admin')),
);
?>

<h1>Permiso Rols</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
