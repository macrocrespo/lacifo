<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->contenido, 'Rol '.$rol->nombre), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel', array('title' => 'Asignar permisos al rol '.$rol->nombre, 'minimized'=>true, 'min_option'=>true, 'remove_option'=>true)); ?>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$rol,
	'attributes'=>array(
                array('name' => 'nombre', 'value' => $rol->nombre),
                array('name' => 'descripcion', 'value' => $rol->descripcion),
                array('name' => 'seguridad', 'value' => $rol->seguridad),
                array('name'=>'estado', 'value'=> $rol->getNombreEstado($rol->estado)),
	),
)); ?>
    
<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('id'=>'permisos_asignados', 'title' => 'Permisos asignados', 'size'=>6)); ?>

    <?php echo $permisos_asignados; ?>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('Panel', array('id'=>'permisos_por_asignar', 'title' => 'Permisos por asignar', 'size'=>6)); ?>

    <?php echo $permisos_por_asignar; ?>

<?php $this->endWidget(); ?>

<input type="hidden" id="tipo" value="rol" />
<input type="hidden" id="id" value="<?php echo $rol->id; ?>" />