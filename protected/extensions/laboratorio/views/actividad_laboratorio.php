<div id="top_menu" class="nav notify-row">
    <!--  notification start -->
    <ul class="nav top-menu">
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-check"></i>
                <span class="badge bg-success">1</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <div class="notify-arrow notify-arrow-green"></div>
                <li>
                    <p class="green">Hay 3 experimentos en curso</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Dashboard v1.3</div>
                            <div class="percent">40%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>



<?php 
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<h5 class="pull-right"><?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]; ?></h5>
<div class="activity terques">
  <span>
      <i class="icon-shopping-cart"></i>
  </span>
  <div class="activity-desk">
      <div class="panel">
          <div class="panel-body">
              <div class="arrow"></div>
              <i class=" icon-time"></i>
              <h4>10:45 AM</h4>
              <p>Purchased new equipments for zonal office setup and stationaries.</p>
          </div>
      </div>
  </div>
</div>
<div class="activity alt purple">
  <span>
      <i class="icon-rocket"></i>
  </span>
  <div class="activity-desk">
      <div class="panel">
          <div class="panel-body">
              <div class="arrow-alt"></div>
              <i class=" icon-time"></i>
              <h4>12:30 AM</h4>
              <p>Lorem ipsum dolor sit amet consiquest dio</p>
          </div>
      </div>
  </div>
</div>
<div class="activity blue">
  <span>
      <i class="icon-bullhorn"></i>
  </span>
  <div class="activity-desk">
      <div class="panel">
          <div class="panel-body">
              <div class="arrow"></div>
              <i class=" icon-time"></i>
              <h4>10:45 AM</h4>
              <p>Please note which location you will consider, or both. Reporting to the VP  you will be responsible for managing.. </p>
          </div>
      </div>
  </div>
</div>

<div class="activity alt green">
  <span>
      <i class="icon-beer"></i>
  </span>
  <div class="activity-desk">
      <div class="panel">
          <div class="panel-body">
              <div class="arrow-alt"></div>
              <i class=" icon-time"></i>
              <h4>12:30 AM</h4>
              <p>Please note which location you will consider, or both.</p>
          </div>
      </div>
  </div>
</div>