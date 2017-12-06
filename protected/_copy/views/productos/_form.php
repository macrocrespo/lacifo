<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'productos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <?php echo $form->dropDownListRow($model, 'familia_id', CHtml::listData(FliaProductos::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Selecionar...')); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'nombre_adic',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'costo',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'habilita',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model, 'usuario_alta_id', CHtml::listData(Usuarios::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Selecionar...')); ?>

        <?php echo $form->dropDownListRow($model, 'usuario_modi_id', CHtml::listData(Usuarios::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Selecionar...')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
