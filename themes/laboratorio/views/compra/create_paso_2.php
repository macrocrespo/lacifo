<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Crear una nueva '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="inactive_wizard">
                <a data-toggle="tab" href="#01">
                    1) Seleccionar proveedor
                </a>
            </li>
            <li class="active active_wizard">
                <a data-toggle="tab" href="#02">
                    2) Seleccionar productos
                </a>
            </li>
            <li class="inactive_wizard">
                <a data-toggle="tab" href="#04">
                    3) Confirmar compra
                </a>
            </li>
        </ul>
        <span class="hidden-sm">Crear una nueva compra</span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="02" class="tab-pane active">

                <div class="alert alert-info fade in">
                    Debe seleccionar los productos que se van a incluir en la compra y la cantidad de los mismos.
                </div>

                <section class="panel" id="panel_productos">
                    <div class="panel-body" style="padding:0px;">
                        <div id="productos_por_compra_wrapper"></div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</section>
</div>



<div class="col-lg-12">
    <div class="" id="panel_agregar_producto_wrapper" style="display: block;">
        <section class="panel" id="panel_agregar_producto">
        <header class="panel-heading ">
            Agregar producto
            <span class="tools pull-right"></span>
        </header>
        <div class="panel-body">
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
        
        </section>
    </div>
</div>

<?php $this->beginWidget('Panel'); ?>

<div class="row">
    <div class="col-md-12">
        
        <div class="form-actions pull-right">
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
        
    </div>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial('_create_paso_2_modals', array('model'=>$model)); ?>

<input type="hidden" id="idCompra" value="<?php echo $model->id; ?>" />