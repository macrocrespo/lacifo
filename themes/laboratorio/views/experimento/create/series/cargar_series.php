<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Crear un nuevo '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>$this->controller.'-series-form',
	'enableAjaxValidation'=>false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'class'     => 'tasi-form',
            'enctype'   => 'multipart/form-data'
        )
)); ?>

<?php echo $this->renderPartial('create/series/_form_cargar_series', 
        array(
            'model'=>$model, 
            'data'=>$data,
            'titulo'=>'Cargar series '
        )); ?>

<?php $this->endWidget(); ?>
<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="cargarSeries" />
<input type="hidden" id="id" value="<?php echo $model->id; ?>" />
