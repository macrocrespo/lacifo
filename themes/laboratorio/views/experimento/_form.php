<?php if ($model->estado == 'INICIADO') { ?>
    <?php echo $this->renderPartial('create/_wizard', array('active'=>'info_inicial')); ?>
<?php } ?>

<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i class="icon-home"></i>
                </a>
            </li>
        </ul>
        <span class=""><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active">
                
                <?php 
                $mensaje = 'Los campos con <strong>*</strong> son requeridos.';
                $this->widget('Mensaje', array('mensaje' => $mensaje, 'icon' => 'chevron-sign-right')); 
                ?>
                    
                <?php echo $form->textFieldRow($model,'titulo',array('class'=>'form-control','maxlength'=>250, 'labelOptions' => array('class' => 'col-sm-4'))); ?>
                    
                <?php $this->widget('Textarea', array('model_name'=>'Experimento', 'campo'=>'descripcion', 'label'=>'Descripción *', 'value'=>$model->descripcion)); ?>
                <br>
                <?php $this->widget('Textarea', array('model_name'=>'Experimento', 'campo'=>'condiciones', 'label'=>'Condiciones *', 'value'=>$model->condiciones)); ?>
                <br>
                <?php $this->widget('Textarea', array('model_name'=>'Experimento', 'campo'=>'resultados', 'label'=>'Resultados *', 'value'=>$model->resultados)); ?>
                
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
                        <button name="yt0" type="submit" class="btn btn-success"><i class="icon-save"></i> Guardar</button> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>