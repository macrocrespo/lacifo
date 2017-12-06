<?php $url_controller = Yii::app()->request->baseUrl.'/'.$this->controller; ?>
<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array($this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel'); ?>
    <a href="<?php echo $url_controller.'/create'; ?>" class="btn btn-success btn-sm" style="color: #fff;">
        <i class="icon-plus-sign-alt"></i> Crear tipo de producto
    </a>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('title' => 'Listado de '.$this->tipo_contenido)); ?>

    <?php $this->widget('Tabla', array(
        'controller' => $this->controller,
        'model' => $model,
        'columnas'=>array(
            array('name'=>'id',             'header'=>'ID'),
            array('name'=>'nombre',         'header'=>'Nombre'),
            array('name'=>'descripcion',    'header'=>'Descripción', 'class'=>'no-mobile'),
            array('name'=>'inicial',        'header'=>'Inicial', 'class'=>'no-mobile'),
            array('name'=>'rubro_id',       'header'=>'Rubro', 'relation' => 'rubro->nombre', 'class'=>'no-phone'),
            ),
        'acciones' => array('ver'=>true, 'editar'=>true, 'eliminar'=>true),
        'validar_eliminacion'=>true,
        'no_sort' => '5',
        'txt_eliminar' => 'el tipo de producto'
    )); ?>

<?php $this->endWidget(); ?>