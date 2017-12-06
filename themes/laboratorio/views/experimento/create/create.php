<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Crear un nuevo '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>$this->controller.'-form',
	'enableAjaxValidation'=>false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'class'     => 'tasi-form',
            'enctype'   => 'multipart/form-data'
        )
)); ?>

<?php echo $this->renderPartial('./_form', 
        array(
            'model'=>$model, 
            'form'=>$form,
            'titulo'=>'Información inicial'
        )); ?>

<?php $this->endWidget(); ?>
<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
