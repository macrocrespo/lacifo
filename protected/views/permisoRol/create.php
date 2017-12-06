<?php
$this->breadcrumbs=array(
	'Permiso Rols'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PermisoRol','url'=>array('index')),
	array('label'=>'Manage PermisoRol','url'=>array('admin')),
);
?>

<h1>Create PermisoRol</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>