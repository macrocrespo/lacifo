<?php 
/* Lista del perfil del usuario (view)
 * Muestra la lista de opciones en el panel del perfil del usuario
 */
?>
<ul class="nav nav-pills nav-stacked">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/tarea"> <i class="icon-check"></i>Tareas asignadas <span class="label label-warning pull-right r-activity"><?php echo $data['cant_tareas']; ?></span></a></li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/notificacion"> <i class="icon-bell"></i>Notificaciones <span class="label label-danger pull-right r-activity"><?php echo $data['cant_notificaciones']; ?></span></a></li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/experimento"> <i class="icon-lightbulb"></i>Experimentos en curso <span class="label label-success pull-right r-activity"><?php echo $data['cant_experimentos']; ?></span></a></li>
    
    <?php /*
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/producto"> <i class="icon-beaker"></i>Productos cargados <span class="label label-primary pull-right r-activity"><?php echo $data['cant_productos']; ?></span></a></li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/compra"> <i class="icon-shopping-cart"></i>Compras realizadas <span class="label label-danger pull-right r-activity"><?php echo $data['cant_compras']; ?></span></a></li>
    */ ?>
</ul>