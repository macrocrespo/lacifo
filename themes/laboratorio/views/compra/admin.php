<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel'); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'success',
        'icon'=>'plus-sign-alt',
        'label'=> 'Crear una nueva '.$this->contenido,
        'url'=> Yii::app()->request->baseUrl.'/'.$this->controller.'/create'
    )); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('title' => 'Listado de '.$this->tipo_contenido)); ?>

    <?php $this->widget('Tabla', array(
        'controller' => $this->controller,
        'model' => $model,
        'columnas'=>array(
            array('name'=>'fecha',          'header'=>'Fecha de compra'),
            array('name'=>'observacion',    'header'=>'Observación'),
            array('name'=>'total',          'header'=>'Monto total ($)'),
            array('name'=>'proveedor_id',   'header'=>'Proveedor', 'relation' => 'proveedor->nombre'),
            ),
        'acciones' => array('ver'=>true)
    )); ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('title' => 'Compras pendientes de confirmación')); ?>

    <?php $this->widget('Tabla', array(
        'controller' => $this->controller,
        'model' => $temp_compras,
        'columnas'=>array(
            array('name'=>'fecha',          'header'=>'Fecha de compra'),
            array('name'=>'observacion',    'header'=>'Observación'),
            array('name'=>'total',          'header'=>'Monto total ($)'),
            array('name'=>'proveedor_id',   'header'=>'Proveedor', 'relation' => 'proveedor->nombre'),
            ),
        'acciones' => array(
            'custom'=> array(
                'action'=>'compra/agregar_productos',
                'type'=>'success',
                'icon'=>'circle-arrow-right',
                'title'=>'Continuar',
            ))
    )); ?>

<?php $this->endWidget(); ?>