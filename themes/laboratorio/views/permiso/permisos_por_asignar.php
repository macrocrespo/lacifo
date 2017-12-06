<?php $this->widget('Tabla', array(
        'controller' => $this->controller,
        'model' => $permisos_por_asignar,
        'columnas'=>array(
            array('name'=>'descripcion', 'header'=>'Sección'),
            array('name'=>'seguridad', 'header'=>'Nivel de seguridad'),
            ),
        'acciones' => array('custom'=>array(
            'js'=>'asignar_permiso([id])',
            'type'=>'success', 
            'icon'=>'unlock', 
            'title'=>'Asignar permiso'))
    )); ?>
