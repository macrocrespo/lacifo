<?php echo $this->renderPartial('create/_wizard', array('active'=>'verificar')); ?>

<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i class="icon-ok-sign"></i>
                </a>
            </li>
        </ul>
        <span class=""><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                <div id="resumen" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('create/verificar_info/_resumen', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;" class="m-bot30"></div>
                
                <div id="info_adicional" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('create/verificar_info/_info_inicial', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;"></div>
                
                <div id="productos" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('create/verificar_info/_productos', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;" class="m-bot30"></div>
                
                <div id="series" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('create/verificar_info/_series', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;" class="m-bot30"></div>
                
                <div id="equipos" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('create/verificar_info/_equipos', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>

            </div>
        </div>
    </div>
</section>
</div>

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            <span class="">
                Estado del experimento</span>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?php $opcion_cambiar_estado = false;
                    if (count($data['productos']) > 0 && count($data['equipos']) > 0) {
                        $opcion_cambiar_estado = true;
                    }
                    ?>
                    
                    <?php if (!$opcion_cambiar_estado) { ?>
                    
                    <div class="alert alert-warning alert-block fade in m-bot10">
                        <h5 class="pull-left m-top5 m-bot5">
                            <i class="icon-warning-sign" style="font-size: 150%;"></i>
                            Para cambiar el estado del experimento, al menos se debe tener 1 producto y 1 equipo asociado.
                        </h5>
                        <div style="clear: both;"></div>
                    </div>
                    
                    <?php } ?>
                    
                    <div class="alert alert-info alert-block fade in m-bot-none">
                        <h5 class="pull-left m-top10 m-bot10">
                            <i class="icon-map-marker" style="font-size: 150%;"></i>
                            <span>El estado actual del experimento es: </span>
                            <strong>INICIADO</strong>.
                        </h5>
                        
                        <div id="opciones-verificar-info" style="display: block;" class="pull-right">
                            <?php if ($opcion_cambiar_estado) {
                            // Habilitar la opción de cambiar estado, si se han agregado productos y equipos ?>
                            <a href="#confirmar_cambiar_estado" data-toggle="modal" class="btn btn-success pull-right m-left10 m-top5"><i class="icon-flag"></i> Cambiar estado</a>
                            <?php } ?>
                            <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller.'/informacionAdicional/'.$model->id; ?>" data-toggle="modal" class="btn btn-primary pull-right m-left10 m-top5"><i class="icon-info-sign"></i> Agregar información</a>
                            <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-warning btn pull-right m-top5"><i class="icon-lightbulb"></i> Ir a experimentos</a>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    
                    <div class="alert alert-block alert-danger fade in m-bot-none" id="error_message" style="display: none;">
                        <div id="message"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="confirmar_cambiar_estado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-flag"></i> Cambiar estado</h4>
            </div>
            <div class="modal-body">
                <strong>Al cambiar de estado, el experimento pasará a estado "Preparado".</strong>
                <br ><br />
                Este cambio significa que los productos y las series cargadas dejarán de estar disponibles para la utilización de los demás experimentos.
                <br ><br />
                ¿Seguro que desea cambiar de estado?
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-success" onclick="cambiar_estado();" type="button">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="experimento_id" value="<?php echo $model->id; ?>" />