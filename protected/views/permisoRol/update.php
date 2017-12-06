<?php
$this->breadcrumbs=array(
	'Permiso Rols'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PermisoRol','url'=>array('index')),
	array('label'=>'Create PermisoRol','url'=>array('create')),
	array('label'=>'View PermisoRol','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PermisoRol','url'=>array('admin')),
);
?>

<h1>Update PermisoRol <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>