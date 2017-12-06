<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'contenedor_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'tipo_producto_id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'descripcion',array('class'=>'span5','maxlength'=>100)); ?>
        
        <?php echo $form->textFieldRow($model,'precio',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'nombre_ingles',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'marca',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'IUPAC',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'CAS',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'usa_serie',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'usa_detalle',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
