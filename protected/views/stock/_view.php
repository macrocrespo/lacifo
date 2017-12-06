<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producto_id')); ?>:</b>
	<?php echo CHtml::encode($data->producto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('minimo')); ?>:</b>
	<?php echo CHtml::encode($data->minimo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maximo')); ?>:</b>
	<?php echo CHtml::encode($data->maximo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sugerido')); ?>:</b>
	<?php echo CHtml::encode($data->sugerido); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->cantidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_ingresa_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_ingresa_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_ingresa')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_ingresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_consume_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_consume_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_consume')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_consume); ?>
	<br />

	*/ ?>

</div>