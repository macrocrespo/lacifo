<?php $this->widget('Tabla', array(
    'controller' => $this->controller,
    'model' => $permisos_asignados,
    'columnas'=>array(
        array('name'=>'seccion_id', 'header'=>'Sección', 'relation' => 'seccion->descripcion'),
        array('name'=>'seccion_id', 'header'=>'Nivel de seguridad', 'relation' => 'seccion->seguridad'),
        ),
    'acciones' => array('custom'=>array(
        'js'=>'quitar_permiso([id])',
        'type'=>'danger', 
        'icon'=>'lock', 
        'title'=>'Remover permiso'))
)); ?>
