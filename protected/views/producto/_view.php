<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contenedor_id')); ?>:</b>
	<?php echo CHtml::encode($data->contenedor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_producto_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_producto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre_ingles')); ?>:</b>
	<?php echo CHtml::encode($data->nombre_ingles); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('marca')); ?>:</b>
	<?php echo CHtml::encode($data->marca); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('IUPAC')); ?>:</b>
	<?php echo CHtml::encode($data->IUPAC); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CAS')); ?>:</b>
	<?php echo CHtml::encode($data->CAS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usa_serie')); ?>:</b>
	<?php echo CHtml::encode($data->usa_serie); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usa_detalle')); ?>:</b>
	<?php echo CHtml::encode($data->usa_detalle); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	*/ ?>

</div>