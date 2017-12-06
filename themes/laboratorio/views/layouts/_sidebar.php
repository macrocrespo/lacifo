<?php
$active = '';
if (isset($this->cod_menu))
    $active = $this->cod_menu;
$this->widget('Menu_lateral', array(
    'items'=>array(        
        array('cod'=>'inicio', 'label'=>'Inicio', 'icon'=>'home', 'url'=>''),
        
        array('cod'=>'tarea', 'label'=>'Tareas', 'icon'=>'check', 'url'=>'tarea'),
        
        array('cod'=>'notificacion', 'label'=>'Notificaciones', 'icon'=>'bell', 'url'=>'notificacion'),
        
        array('cod'=>'experimento', 'label'=>'Gestión de experimentos', 'icon'=>'lightbulb', 'url'=>'experimento'),
        
        array('cod'=>'productos', 'label'=>'Gestión de productos', 'icon'=>'beaker', 'url'=>'#', 'items'=>array(
            array('cod'=>'producto', 'label'=>'Productos', 'icon'=>'beaker', 'url'=>'producto'),
            array('cod'=>'rubro', 'label'=>'Rubros', 'icon'=>'bookmark', 'url'=>'rubro'),
            array('cod'=>'tipo_producto', 'label'=>'Tipos de producto', 'icon'=>'tags', 'url'=>'tipo_producto'),
            array('cod'=>'deposito', 'label'=>'Depósitos', 'icon'=>'building', 'url'=>'deposito'),
            array('cod'=>'contenedor', 'label'=>'Contenedores', 'icon'=>'archive', 'url'=>'contenedor'),
        )),
        
        /*
        
        array('cod'=>'equipo', 'label'=>'Gestión de equipos', 'icon'=>'rocket', 'url'=>'equipo'),
        
        array('cod'=>'stock', 'label'=>'Control de stock', 'icon'=>'shopping-cart', 'url'=>'#', 'items'=>array(
            array('cod'=>'compra', 'label'=>'Compras', 'icon'=>'shopping-cart', 'url'=>'compra'),
            array('cod'=>'proveedor', 'label'=>'Proveedores', 'icon'=>'truck', 'url'=>'proveedor'),
        )),
        
        array('cod'=>'config', 'label'=>'Configuración', 'icon'=>'gears', 'url'=>'#', 'items'=>array(
            array('cod'=>'usuario', 'label'=>'Usuarios', 'icon'=>'user', 'url'=>'usuario'),
            array('cod'=>'rol', 'label'=>'Roles', 'icon'=>'group', 'url'=>'rol'),
            array('cod'=>'seccion', 'label'=>'Secciones', 'icon'=>'flag', 'url'=>'seccion'),
            array('cod'=>'permiso', 'label'=>'Permisos', 'icon'=>'unlock-alt', 'url'=>'permiso'),
        )),
        
        */
        
        array('cod'=>'manual', 'label'=>'Manual de usuario', 'icon'=>'book', 'url'=>'manual_usuario.pdf'),
        
        /*
        array('cod'=>'encuesta', 'label'=>'Realizar la encuesta', 'icon'=>'comment-alt', 'url'=>'https://goo.gl/forms/zYVwdQUIL7iamUQt1', 'external_link'=>true),
         */
        
        array('cod'=>'logout', 'label'=>'Cerrar sesión', 'icon'=>'power-off', 'url'=>'site/logout'),
    ),
    'active' => $active,
));
?>
