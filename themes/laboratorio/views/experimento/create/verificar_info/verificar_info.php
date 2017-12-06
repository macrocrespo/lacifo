<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Crear un nuevo '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php echo $this->renderPartial('create/verificar_info/_form_verificar_info', 
        array(
            'model'=>$model, 
            'data'=>$data,
            'titulo'=>'Verificar información '
        )); ?>

<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="verificarInfo" />
<input type="hidden" id="id" value="<?php echo $model->id; ?>" />
