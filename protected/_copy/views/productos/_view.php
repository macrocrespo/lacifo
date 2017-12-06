<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('familia_id')); ?>:</b>
	<?php echo CHtml::encode($data->familia_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_adic')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_adic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('costo')); ?>:</b>
	<?php echo CHtml::encode($data->costo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('habilita')); ?>:</b>
	<?php echo CHtml::encode($data->habilita); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_alta')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_alta); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_modi')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_modi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_alta_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_alta_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_modi_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_modi_id); ?>
	<br />

	*/ ?>

</div>