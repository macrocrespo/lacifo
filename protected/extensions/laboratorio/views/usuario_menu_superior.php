<ul class="nav pull-right top-menu">
  <!--
  <li>
      <input type="text" class="form-control search" placeholder="Buscar...">
  </li>
  -->
  <!-- user login dropdown start-->
  <li class="dropdown">
      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
          <img width="22px" alt="" src="<?php echo Yii::app()->request->baseUrl.'/'; ?>images/usuarios/<?php echo Yii::app()->user->imagen; ?>">
          <span class="username no-mobile"><?php echo Yii::app()->user->nombre; ?></span>
          <b class="caret"></b>
      </a>
      <ul class="dropdown-menu extended logout">
          <div class="log-arrow-up"></div>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/tarea"><i class="icon-check-sign"></i>Tareas</a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/notificacion"><i class=" icon-bell-alt"></i>Notificaciones</a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout"><i class="icon-power-off"></i>Cerrar sesi&oacute;n</a></li>
      </ul>
  </li>
  <!-- user login dropdown end -->
</ul>