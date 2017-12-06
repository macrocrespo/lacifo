<aside class="profile-nav alt green-border">
  <section class="panel">
      <div class="user-heading alt green-bg">
          <a href="#">
              <img alt="" src="<?php echo Yii::app()->request->baseUrl.'/'; ?>images/usuarios/<?php echo Yii::app()->user->imagen; ?>">
          </a>
          <h1><?php echo Yii::app()->user->nombre; ?></h1>
          <p><?php echo Yii::app()->user->mail; ?></p>
      </div>

      <ul class="nav nav-pills nav-stacked">
          <li><a href="javascript:;"> <i class="icon-check-sign"></i>Tareas <span class="label label-info pull-right r-activity">11</span></a></li>
          <li><a href="javascript:;"> <i class="icon-envelope-alt"></i>Mensajes <span class="label label-success pull-right r-activity">10</span></a></li>
      </ul>
  </section>
</aside>