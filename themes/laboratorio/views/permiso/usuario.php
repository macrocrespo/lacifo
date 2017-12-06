<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->contenido, 'Usuario '.$usuario->nombre), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel', array('title' => 'Asignar permisos al usuario '.$usuario->nombre, 'minimized'=>true, 'min_option'=>true, 'remove_option'=>true)); ?>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$usuario,
	'attributes'=>array(
                array('name'=>'imagen', 'type'=>'raw', 
                    'value'=> CHtml::image(
                            $usuario->getImagen($usuario->imagen),
                            'Imagen',
                            array('class'=>'image_in_details'))
                    ),
                array('name' => 'rol_id', 'value' => $usuario->rol->nombre),
                array('name'=>'estado', 'value'=> $usuario->getNombreEstado($usuario->estado)),
	),
)); ?>
    
<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('id'=>'permisos_asignados', 'title' => 'Permisos asignados', 'size'=>6)); ?>

    <?php echo $permisos_asignados; ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('id'=>'permisos_por_asignar', 'title' => 'Permisos por asignar', 'size'=>6)); ?>

    <?php echo $permisos_por_asignar; ?>

<?php $this->endWidget(); ?>

<input type="hidden" id="tipo" value="usuario" />
<input type="hidden" id="id" value="<?php echo $usuario->id; ?>" />