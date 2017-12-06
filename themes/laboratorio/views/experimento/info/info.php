<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Información adicional del '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php echo $this->renderPartial('info/_form_info', 
        array(
            'model'=>$model, 
            'data'=>$data,
            'titulo'=>'Información adicional del experimento'
        )); ?>

<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="infoAdicional" />