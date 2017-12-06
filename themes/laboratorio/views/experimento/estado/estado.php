<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Estado del '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php echo $this->renderPartial('estado/_form_estado', 
        array(
            'model'=>$model, 
            'data'=>$data,
            'titulo'=>'Estado del experimento'
        )); ?>

<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="cambiarEstado" />
<input type="hidden" id="id" value="<?php echo $model->id; ?>" />
<input type="hidden" id="estado" value="<?php echo $model->estado; ?>" />