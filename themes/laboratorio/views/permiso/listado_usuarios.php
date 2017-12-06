<?php $this->beginWidget('Panel', array('title' => 'Listado de usuarios')); ?>

    <?php $this->widget('Tabla', array(
        'controller' => 'permiso',
        'model' => $model,
        'columnas'=>array(
            array('name'=>'id',         'header'=>'ID'),
            array('name'=>'nombre',     'header'=>'Nombre de usuario'),
            array('name'=>'rol_id',     'header'=>'Rol', 'relation' => 'rol->nombre')),
        'acciones' => array('custom'=>array(
            'action'=>'permiso/usuario', 
            'type'=>'primary', 
            'icon'=>'unlock', 
            'title'=>'Asignar permisos'))
    )); ?>

<?php $this->endWidget(); ?>