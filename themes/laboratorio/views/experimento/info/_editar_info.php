<?php $experimento = (object) $model; ?>

<div class="alert alert-success alert-block fade in m-bot30">
    <h5 class="pull-left" style="font-size: 1.2em;">
        <i class="icon-lightbulb"></i>
        <strong><?php echo $experimento->titulo; ?></strong>
    </h5>
    <a href="<?php echo Yii::app()->request->baseUrl.'/experimento/view/'.$model->id; ?>" class="btn-success btn btn-sm pull-right m-top5"><i class="icon-double-angle-right"></i> Ver detalles</a>
    <div style="clear: both;"></div>
</div>

<h2 id="titulo_listado" class="subtitle text-info">
    <i class="icon-info-sign"></i>
    <strong>Listado de información<span class="no-phone"> adicional</span></strong>
</h2>

<div id="listado_informacion_adicional"></div>

<?php $this->widget('Mensaje_listado', array(
    'mensaje'   => 'La información se ha editado correctamente',
    'class'     => 'mensaje_info_editada_ok pad-left0 pad-right0',
    'type'      => 'success'
)); ?>

<?php $this->widget('Mensaje_listado', array(
    'mensaje'   => 'La información se ha eliminado correctamente',
    'class'     => 'mensaje_info_eliminada_ok pad-left0 pad-right0',
    'type'      => 'success'
)); ?>

<div id="editar_info_wrapper" style="display: none;">
    <br>
    <br>
    <?php $this->widget('Textarea', array('model_name'=>'Experimento', 'campo'=>'editar_informacion')); ?>
    <input type="hidden" id="estado_id" value="" />
    <br>
    
    <div class="col-lg-3 pad-left0 pad-right0">
        <a style="cursor: pointer;" onclick="ocultar_form_editar_info_adicional();" class="btn btn-danger m-top10"><i class="icon-ban-circle"></i> Cancelar</a>
        <a style="cursor: pointer;" onclick="editar_info_adicional();" class="btn btn-success m-top10"><i class="icon-save"></i> Guardar</a>
    </div>
    <div class="col-lg-9 pad-right0 pad-left0">
        <div id="error_message_edit" class="alert alert-danger alert-block fade in m-bot0 m-top10" style="display: none;"><i class="icon-warning-sign pull-left m-right10" style="margin-top: 2px;"></i> <div id="message"></div> </div>
    </div>
    
    <div style="clear: both;"></div>
</div>