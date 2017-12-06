<?php
$this->breadcrumbs=array(
	'Permiso Usuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PermisoUsuario','url'=>array('index')),
	array('label'=>'Manage PermisoUsuario','url'=>array('admin')),
);
?>

<h1>Create PermisoUsuario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>