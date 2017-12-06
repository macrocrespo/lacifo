
    <div class="col-lg-12">
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 'Detalle de la '.$this->contenido), 'separator' => ''
        )); ?>
    </div>

    <?php $this->beginWidget('Panel', array('title' => 'Detalle de la '.$this->contenido, 'size'=>6)); ?>

    <?php 
    $this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'id',
                    'fecha',
                    'total',
                    'observacion',
                    array('name' => 'proveedor_id', 'value' => $model->proveedor->nombre),
                    array('name'=>'estado', 'value'=> $model->getNombreEstado($model->estado)),
            ),
    )); ?>

    <?php $this->endWidget(); ?>
    
    <?php $this->beginWidget('Panel', array('title' => 'Productos incluidos en la compra ', 'size'=>6)); ?>

    <?php $this->widget('Tabla', array(
        'controller' => 'producto',
        'model' => $productos,
        'columnas'=>array(
            array('name'=>'nombre',         'header'=>'Nombre'),
            array('name'=>'rc_precio',      'header'=>'Costo ($)'),
            array('name'=>'rc_cantidad',    'header'=>'Cantidad'),
            array('name'=>'rc_total',       'header'=>'Subtotal ($)')
        ),
        'acciones' => array('custom'=>array(
            array(
                'type'=>'info',
                'icon'=>'info-sign',
                'title'=>'Ver producto',
                'action'=>'producto/view',
            )
        ))
    )); ?>

    <?php $this->endWidget(); ?>

    <?php $this->beginWidget('Panel', array('title' => 'Opciones', 'min_option' => true, 'size'=>6)); ?>


        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'info',
            'url'=> Yii::app()->request->baseUrl.'/'.$this->controller,
            'icon'=>'list',
            'label'=> 'Ir al listado',
            'htmlOptions'=>array('class'=>'pull-right')
        )); ?>

    <?php $this->endWidget(); ?>