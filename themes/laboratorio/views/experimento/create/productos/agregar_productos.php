<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Crear un nuevo '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php echo $this->renderPartial('create/productos/_form_agregar_productos', 
        array(
            'model'=>$model, 
            'tipo_productos'=>$tipo_productos,
            'titulo'=>'Agregar productos '
        )); ?>

<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="agregarProductos" />
<input type="hidden" id="id" value="<?php echo $model->id; ?>" />
