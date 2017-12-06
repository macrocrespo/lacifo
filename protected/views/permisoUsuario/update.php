<?php
$this->breadcrumbs=array(
	'Permiso Usuarios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PermisoUsuario','url'=>array('index')),
	array('label'=>'Create PermisoUsuario','url'=>array('create')),
	array('label'=>'View PermisoUsuario','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PermisoUsuario','url'=>array('admin')),
);
?>

<h1>Update PermisoUsuario <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>