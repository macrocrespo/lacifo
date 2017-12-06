<div class="row">
    <div class="col-lg-12">
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>array('Control de stock', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 'Crear una nueva '.$this->contenido), 'separator' => ''
        )); ?>
    </div>
</div>

<div class="row">

    <?php $this->beginWidget('Panel', array('id' => 'panel_mensaje', 'title' => 'Crear una nueva '.$this->contenido, 'size'=>12)); ?>

        <?php 
        $titulo = 'Paso 2:';
        $mensaje = 'Debe seleccionar los productos que se van a incluir en la compra y la cantidad de los mismos.';
        $this->widget('Mensaje', array('mensaje' => $mensaje, 'titulo' => $titulo, 'icon' => 'chevron-sign-right')); 
        ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Información de compra',
            'icon'=>'info-sign',
            'url'=>'javascript:ver_compra_details();',
            'htmlOptions' => array('class'=> 'btn-info btn-sm pull-right')
        )); ?>

    <?php $this->endWidget(); ?>

    <?php $this->beginWidget('Panel', array('id' => 'panel_info_compra', 'title' => 'Información general', 'size'=>6, 'style' => 'display: none;')); ?>

        <?php 
        $this->widget('bootstrap.widgets.TbDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                        'id',
                        array('name' => 'proveedor_id', 'value' => $model->proveedor->nombre),
                        'fecha',
                ),
        )); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Ocultar',
            'icon'=>'ban-circle',
            'url'=>'javascript:ocultar_compra_details();',
            'htmlOptions' => array('class'=> 'btn-default btn-sm pull-right')
        )); ?>  

    <?php $this->endWidget(); ?>
    
</div>

<div class="row">
    
    <?php $this->beginWidget('Panel', array('id' => 'panel_productos', 'title' => 'Productos incluidos en la compra', 'size'=>12)); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'success',
            'icon'=>'plus-sign-alt',
            'label'=> 'Agregar producto',
            'url'=>'javascript:ver_agregar_producto();',
            'htmlOptions' => array('class'=> 'btn-sm')
        )); ?>
    
        <div id="productos_por_compra_wrapper"></div>
    
    <?php $this->endWidget(); ?>
        
    <?php $this->beginWidget('Panel', array('id' => 'panel_agregar_producto', 'title' => 'Agregar producto', 'size'=>6, 'style' => 'display: none;')); ?>

        <?php $this->widget('Textbox', array('campo' => 'nombre_producto', 'label' => 'Nombre o código del producto')); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Buscar',
            'icon'=>'search',
            'url'=>'javascript:buscar_productos();',
            'htmlOptions' => array('class'=> 'btn-primary pull-right')
        )); ?> 
        
        <div id="productos_encontrados"></div>
        
        <br /><br /><br />
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Ocultar',
            'icon'=>'ban-circle',
            'url'=>'javascript:ocultar_agregar_producto();',
            'htmlOptions' => array('class'=> 'btn-default btn-sm pull-right')
        )); ?> 
        
    <?php $this->endWidget(); ?>

</div>

<div class="row">
    <?php $this->beginWidget('Panel', array('title' => 'Opciones', 'size'=>12)); ?>
    <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Cancelar',
                'icon'=>'ban-circle',
                'url'=>'javascript:history.back();',
                'htmlOptions' => array('class'=> 'btn-default')
            )); ?>
            
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'danger',
                'icon'=>'remove-sign',
                'label'=>'Anular',
                'url'=> '#anular_compra',
                'htmlOptions' => array('data-toggle'=>'modal')
            )); ?>
        
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'success',
                'icon'=>'check-sign',
                'label'=>'Confirmar',
                'url'=> '#confirmar_compra',
                'htmlOptions' => array('data-toggle'=>'modal')
            )); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php $this->renderPartial('_create_paso_2_modals', array('model'=>$model)); ?>

<input type="hidden" id="idCompra" value="<?php echo $model->id; ?>" />