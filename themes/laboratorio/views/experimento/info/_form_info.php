<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i title="Agregar información" class="icon-plus-sign-alt"></i>
                    <span class="no-mobile">Agregar</span>
                </a>
            </li>
            <li class="" id="tab2">
                <a data-toggle="tab" href="#02">
                    <i title="Editar información" class="icon-edit-sign"></i>
                    <span class="no-mobile">Editar</span>
                </a>
            </li>
        </ul>
        Información adicional<span class="no-phone"> del experimento</span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                <div id="info_basica" class="col-lg-12 no-padding-mobile">
                    <?php echo $data['info_basica']; ?>
                </div>
                <div style="clear: both;"></div>
                
                <div id="agregar_info" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('info/_agregar_info', 
                        array(
                            'model'=>$model, 
                            'data'=>$data
                        )); ?>
                </div>
                <div style="clear: both;"></div>
      
            </div>
            
            <div id="02" class="tab-pane">
                
                <div id="listado_mas_info" class="col-lg-12 no-padding-mobile">
                    <?php echo $this->renderPartial('info/_editar_info', 
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
                <div class="col-md-8">
                    <?php $this->widget('Mensaje', array(
                        'mensaje'   => 'Si lo desea, puede cambiar el estado del experimento haciendo <a class="underline" href="'.Yii::app()->request->baseUrl.'/'.$this->controller.'/cambiarEstado/'.$model->id.'" >click aquí</a>.',
                        'type'      => 'info',
                        'show_icon' => true,
                        'close'     => false,
                        'margin'    => false
                    )); ?>
                    <div class="hidden-lg hidden-md m-bot20"></div> 
                </div>
                <div class="col-md-4">
                    <div class="form-actions pull-right">
                        <a id="btn_agregar_info" style="cursor: pointer; display: none;" onclick="$('#tab1 a').click(); goto('titulo_agregar', 1);" class="btn btn-primary pull-right m-left10" ><i class="icon-plus-sign-alt"></i> Agregar información</a>
                        <a id="btn_editar_info" style="cursor: pointer;" onclick="$('#tab2 a').click(); goto('titulo_listado', 1);" class="btn btn-primary pull-right m-left10"><i class="icon-edit-sign"></i> Editar información</a> 
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-danger btn pull-right"><i class="icon-chevron-left"></i> Volver</a>       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<input type="hidden" id="experimento_id" name="experimento_id" value="<?php echo $model->id; ?>" />