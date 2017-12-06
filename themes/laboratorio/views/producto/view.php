<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Detalles de '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<div id="panel-detalles" class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            Detalles<span class="no-phone"> del producto</span>
        </header>
        <div class="panel-body">

            <?php echo $this->renderPartial('_view_detalles', 
                    array(
                        'model'=>$model,
                        'rubro'=>$rubro,
                        'deposito'=>$deposito,
                        'producto_detalle'=>$producto_detalle,
                        'stock'=>$stock,
                        'stock_data'=>$stock_data
                    )); ?>

        </div>
    </section>
</div>

<div id="panel-experimentos" class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            Experimentos<span class="no-phone"> que utilizan este producto</span>
        </header>
        <div class="panel-body">
            <div id="listado_experimentos"></div>
        </div>
    </section>
</div>

<?php $this->renderPartial('../site/_view_opciones_generales', array('model'=>$model)); ?>

<input type="hidden" id="producto_id" value="<?php echo $model->id; ?>" />
<input type="hidden" id="tipo" value="producto" />
<input type="hidden" id="idView" value="detalles" />
<input type="hidden" id="validar_eliminacion" value="1" />