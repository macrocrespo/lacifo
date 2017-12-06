<div id="top_menu" class="nav notify-row">
    <!--  notification start -->
    <ul class="nav top-menu">
        
        <li class="dropdown">
            <?php /*
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-lightbulb"></i>
                <span class="badge bg-success">7</span>
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
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Database Update</div>
                            <div class="percent">60%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-warning">
                                <span class="sr-only">60% Complete (warning)</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Iphone Development</div>
                            <div class="percent">87%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 87%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                                <span class="sr-only">87% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Mobile App</div>
                            <div class="percent">33%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 33%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">33% Complete (danger)</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Dashboard v1.3</div>
                            <div class="percent">45%</div>
                        </div>
                        <div class="progress progress-striped active">
                            <div style="width: 45%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar">
                                <span class="sr-only">45% Complete</span>
                            </div>
                        </div>

                    </a>
                </li>
                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        
        <!-- settings start -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-check"></i>
                <span class="badge bg-warning">6</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <div class="notify-arrow notify-arrow-yellow"></div>
                <li>
                    <p class="yellow">Usted tiene 3 tares pendientes</p>
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
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Database Update</div>
                            <div class="percent">60%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 60%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-warning">
                                <span class="sr-only">60% Complete (warning)</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Iphone Development</div>
                            <div class="percent">87%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 87%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="20" role="progressbar" class="progress-bar progress-bar-info">
                                <span class="sr-only">87% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Mobile App</div>
                            <div class="percent">33%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div style="width: 33%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar progress-bar-danger">
                                <span class="sr-only">33% Complete (danger)</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">Dashboard v1.3</div>
                            <div class="percent">45%</div>
                        </div>
                        <div class="progress progress-striped active">
                            <div style="width: 45%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar">
                                <span class="sr-only">45% Complete</span>
                            </div>
                        </div>

                    </a>
                </li>
                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        <!-- settings end -->
         * 
         */ ?>

        <?php if ($cant_notificaciones > 0) { ?>
            <!-- NOTIFICACIONES DE STOCK -->
            <li class="dropdown" id="header_notification_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <i class="icon-bell-alt"></i>
                    <span class="badge bg-<?php echo $class; ?>"><?php echo $cant_notificaciones; ?></span>
                </a>
                <ul class="dropdown-menu extended notification">
                    <div class="notify-arrow notify-arrow-<?php echo $color; ?>"></div>
                    <li>
                        <p class="<?php echo $color; ?>">Hay <?php echo $cant_notificaciones; ?> notificaciones</p>
                    </li>
                    <?php foreach ($stock as $s) { ?>
                    <li>
                        <a style="cursor: default;">
                            <span class="label label-<?php echo $s->class; ?> icon_notification"><i class="icon-beaker"></i></span>
                            <div class="text_notification">
                                <?php if ($s->menor_minimo) { ?>
                                    El producto <strong><?php echo $s->nombre; ?></strong><br>tiene una cantidad menor a la mínima.
                                    <br><span class="italic text-<?php echo $s->class; ?>">Se debe aumentar el stock urgente.</span>
                                <?php } else { ?>
                                    El producto <strong><?php echo $s->nombre; ?></strong><br>tiene una cantidad menor a la sugerida.
                                    <br><span class="italic text-<?php echo $s->class; ?>">Se debe aumentar el stock en lo posible.</span>
                                <?php } ?>
                            </div>
                            <div style="clear: both;"></div>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($cant_notificaciones > 5) { ?>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/notificacion">
                            <span class="label label-success icon_notification"><i class="icon-bell-alt"></i></span>
                            <div class="text_notification">
                                Ver todas las notificaciones
                            </div>
                            <div style="clear: both;"></div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- FIN NOTIFICACIONES DE STOCK -->
        <?php } ?>
    </ul>
    <!--  notification end -->
</div>