<?php echo $this->renderPartial('create/_wizard', array('active'=>'equipos')); ?>

<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i title="Equipos agregados" class="icon-rocket"></i>
                    <span class="no-mobile">Equipos agregados</span>
                </a>
            </li>
            <li class="" id="tab2">
                <a data-toggle="tab" href="#02">
                    <i title="Buscar equipos" class="icon-search"></i>
                    <span class="no-mobile">Buscar equipos</span>
                </a>
            </li>
        </ul>
        <span class=""><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                <a onclick="$('#tab2 a').click();" class="btn btn-success btn-sm" style="color: #fff;">
                    <i class="icon-search"></i> Buscar equipos
                </a>
                
                <?php $this->widget('Mensaje_listado', array(
                    'mensaje'   => 'El equipo se ha eliminado correctamente',
                    'class'     => 'no-padding-mobile mensaje_equipo_eliminado',
                    'type'      => 'success'
                )); ?>
  
                <div id="equipos_por_experimento" class="col-lg-12 pad-left0 pad-right0"></div>

            </div>
            <div id="02" class="tab-pane">
                
                <div class="col-lg-12 no-padding-mobile">
                    <form method="POST" class="inline-search form-inline" id="buscar-equipos-form">
                        <input type="hidden" id="experimento_id" name="experimento_id" value="<?php echo $model->id; ?>" />
                        <div class="form-group m-top10">
                            <label class="label-equipos" for="nombre">Nombre</label>
                            <input type="text" class="form-control input-sm" name="nombre">
                        </div>
                        
                        <div class="form-group m-top10">
                            <label class="label-equipos" for="marca">Marca</label>
                            <input type="text" class="form-control input-sm" name="marca">
                        </div>

                        <div class="form-group m-top10">
                            <label class="label-equipos" for="estado">Estado</label>
                            <select class="form-control input-sm" name="estado">
                                <option value=""></option>
                                <option value="Bueno">Bueno</option>
                                <option value="Regular">Regular</option>
                                <option value="Malo">Malo</option>
                            </select>
                        </div>

                        <button id="buscar" type="submit" class="btn btn-primary input-sm m-top10">Buscar</button>
                    </form>
                </div>
                
                <?php $this->widget('Mensaje_listado', array(
                    'mensaje'   => 'Se ha agregado un nuevo equipo correctamente',
                    'class'     => 'no-padding-mobile mensaje_equipo_agregado',
                    'type'      => 'success'
                )); ?>
                
                <?php $this->widget('Mensaje_listado', array(
                    'mensaje'   => 'Para ver los equipos agregados, <a style="cursor: pointer;" onclick="$(\'#tab1 a\').click();">click aquí</a>.',
                    'class'     => 'no-padding-mobile mensaje_ver_equipos_seleccionados',
                    'type'      => 'warning'
                )); ?>

                <div id="busqueda_equipos" class="col-lg-12 no-padding-mobile"></div>

            </div>
        </div>
    </div>
</section>
</div>

<div class="col-lg-12" style="">
    <section class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-block alert-danger fade in m-bot-none" id="error_message" style="display: none;">
                        <div id="message"></div>
                    </div>
                    <div class="hidden-lg hidden-md m-bot20"></div> 
                </div>
                <div class="col-md-4">
                    <div class="form-actions pull-right">
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-danger btn"><i class="icon-ban-circle"></i> Cancelar</a>
                        <button onclick="javascript:validar_equipos();" name="yt0" type="submit" class="btn btn-success"><i class="icon-chevron-sign-right"></i> Continuar</button>        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>