<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->contenido), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel'); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'success',
        'icon'=>'plus-sign-alt',
        'label'=> 'Crear un nuevo '.$this->contenido,
        'url'=> Yii::app()->request->baseUrl.'/'.$this->controller.'/create'
    )); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('title' => 'Listado de '.$this->tipo_contenido)); ?>

    <?php $this->widget('Tabla', array(
        'controller' => $this->controller,
        'model' => $model,
        'columnas'=>array(
            array('name'=>'id',         'header'=>'ID'),
            array('name'=>'nombre',     'header'=>'Nombre de usuario'),
            array('name'=>'rol_id',     'header'=>'Rol', 'relation' => 'rol->nombre')),
        'acciones' => array('ver'=>true, 'editar'=>true, 'eliminar'=>true)
    )); ?>

<?php $this->endWidget(); ?>