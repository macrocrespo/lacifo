<?php $this->beginWidget('Panel', array('title' => 'Listado de roles')); ?>

    <?php $this->widget('Tabla', array(
        'controller' => 'permiso',
        'model' => $model,
        'columnas'=>array(
            array('name'=>'id',         'header'=>'ID'),
            array('name'=>'nombre',     'header'=>'Nombre del rol'),),
        'acciones' => array('custom'=>array(
            'action'=>'permiso/rol', 
            'type'=>'primary', 
            'icon'=>'unlock', 
            'title'=>'Asignar permisos'))
    )); ?>

<?php $this->endWidget(); ?>