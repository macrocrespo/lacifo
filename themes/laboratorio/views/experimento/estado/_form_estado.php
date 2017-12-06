<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i class="icon-map-marker"></i>
                </a>
            </li>
        </ul>
        <span class=""><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                <div id="info_basica" class="col-lg-12 no-padding-mobile">
                    <?php echo $data['info_basica']; ?>
                </div>
                <div style="clear: both;"></div>
                
                <div id="wizard_estados" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('estado/_wizard_estados', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;"></div>
      
            </div>
        </div>
    </div>
</section>
</div>

<div class="col-lg-12" style="">
    <section class="panel">
        <div class="panel-body">
            <div class="row">
                
                <?php if (!$data['opcion_cambiar_estado']) { ?>
                <div class="col-sm-12">
                    <div class="alert alert-danger alert-block fade in m-bot10">
                        <h5 class="pull-left m-top10">
                            <i class="icon-warning-sign"></i>
                            Para cambiar el estado del experimento, al menos se debe tener 1 producto y 1 equipo asociado.
                        </h5>
                        <a href="<?php echo Yii::app()->request->baseUrl.'/experimento/agregarEquipos/'.$model->id; ?>" class="btn-success btn btn-sm pull-right m-top5"><i class="icon-rocket"></i> Agregar equipos</a>
                        <a href="<?php echo Yii::app()->request->baseUrl.'/experimento/agregarProductos/'.$model->id; ?>" class="btn-success btn btn-sm pull-right m-top5 m-right10"><i class="icon-beaker"></i> Agregar productos</a>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <?php } ?>
                
                <div class="col-md-8">
                    <?php if ($model->estado != 'FINALIZADO') {
                        $this->widget('Mensaje', array(
                            'mensaje'   => 'Si lo desea, puede agregar información adicional antes de cambiar de estado haciendo <a class="underline" href="'.Yii::app()->request->baseUrl.'/'.$this->controller.'/informacionAdicional/'.$model->id.'" >click aquí</a>.',
                            'type'      => 'info',
                            'show_icon' => true,
                            'close'     => false,
                            'margin'    => false
                        ));
                    } else {
                        $this->widget('Mensaje', array(
                            'mensaje'   => 'El experimento no puede cambiar de estado debido a que se encuentra en estado <strong>FINALIZADO</strong>.',
                            'type'      => 'warning',
                            'show_icon' => true,
                            'close'     => false,
                            'margin'    => false
                        ));
                    } ?>
                    <div class="hidden-lg hidden-md m-bot20"></div> 
                </div>
                <div class="col-md-4">
                    <div class="form-actions pull-right">
                        
                        <?php if ($model->estado != 'FINALIZADO' && $data['opcion_cambiar_estado']) { ?>
                        <a class="btn btn-success pull-right m-left10 m-top5" href="#confirmar_cambiar_estado" data-toggle="modal" ><i class="icon-flag"></i> Cambiar estado</a>
                        <?php } ?>
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-danger btn pull-right m-top5"><i class="icon-chevron-left"></i> Volver</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if ($data['mensaje'] != '') { ?>
<div class="modal fade" id="confirmar_cambiar_estado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-flag"></i> Cambiar estado</h4>
            </div>
            <div class="modal-body">
                <?php echo $data['mensaje']; ?>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-success" onclick="cambiar_estado();" type="button">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<input type="hidden" name="experimento_id" value="<?php echo $model->id; ?>" />