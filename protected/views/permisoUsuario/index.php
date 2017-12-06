<?php
$this->breadcrumbs=array(
	'Permiso Usuarios',
);

$this->menu=array(
	array('label'=>'Create PermisoUsuario','url'=>array('create')),
	array('label'=>'Manage PermisoUsuario','url'=>array('admin')),
);
?>

<h1>Permiso Usuarios</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
