<div id="panel-detalles" class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i title="Información inicial" class="icon-home"></i>
                    <span class="no-mobile no-small-pc">Información inicial</span>
                </a>
            </li>
            <li class="" id="tab2">
                <a data-toggle="tab" href="#02">
                    <i title="Productos y equipos" class="icon-beaker"></i>
                    <span class="no-mobile no-small-pc">Productos y equipos</span>
                </a>
            </li>
            <li class="" id="tab3">
                <a data-toggle="tab" href="#03">
                    <i title="Más información" class="icon-info-sign"></i>
                    <span class="no-mobile no-small-pc">Más información</span>
                </a>
            </li>
        </ul>
        Detalles<span class="no-phone"> del experimento</span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                <div id="info_inicial" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('view/_info_inicial', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;"></div>
      
            </div>
            
            <div id="02" class="tab-pane">
                
                <div id="productos_equipos" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('view/_resumen', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                    <div style="clear: both;"></div>
                    
                    <?php echo $this->renderPartial('view/_productos', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                    <div style="clear: both;"></div>
                    
                    <?php echo $this->renderPartial('view/_series', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                    <div style="clear: both;"></div>
                    
                    <?php echo $this->renderPartial('view/_equipos', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                    <div style="clear: both;" class="m-bot20"></div>
                    
                    <a style="cursor: pointer; display: inline-block;" onclick="$('#tab1 a').click(); goto('panel-detalles', 1);" class="btn-sm btn-info m-right5 m-bot10"><i class="icon-home"></i> Información inicial</a>
                    <a style="cursor: pointer; display: inline-block;" onclick="$('#tab3 a').click(); goto('panel-detalles', 1);" class="btn-sm btn-info m-bot10"><i class="icon-info-sign"></i> Más información</a>
                    <div style="clear: both;"></div>
        
                </div>
                <div style="clear: both;"></div>
                
            </div>
            
            <div id="03" class="tab-pane">
                <div id="info_adicional" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('view/_info_adicional', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;" class="m-bot20"></div>
                
                <div id="log" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('view/_log', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;" class="m-bot20"></div>
                
                <a style="cursor: pointer; display: inline-block;" onclick="$('#tab1 a').click(); goto('panel-detalles', 1);" class="btn-sm btn-info m-right5 m-bot10"><i class="icon-home"></i> Información inicial</a>
                <a style="cursor: pointer; display: inline-block;" onclick="$('#tab2 a').click(); goto('panel-detalles', 1);" class="btn-sm btn-info m-bot10"><i class="icon-beaker"></i> Productos y equipos</a>
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
                <div class="col-md-12">
                    <div class="form-actions pull-right">
                        <?php if ($model->estado != 'FINALIZADO') { ?>
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller.'/cambiarEstado/'.$model->id; ?>" class="btn btn-success pull-right m-left10"><i class="icon-flag"></i> Cambiar estado</a>
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller.'/informacionAdicional/'.$model->id; ?>" data-toggle="modal" class="btn btn-primary pull-right m-left10"><i class="icon-info-sign"></i> Agregar información</a>
                        <?php } ?>
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-danger btn pull-right"><i class="icon-chevron-left"></i> Volver</a>       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<input type="hidden" name="experimento_id" value="<?php echo $model->id; ?>" />