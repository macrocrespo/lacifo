<h2 id="titulo_agregar" class="subtitle text-success">
    <i class="icon-plus-sign-alt"></i>
    <strong>Agregar información</strong>
</h2>
<br>
<?php $this->widget('Textarea', array('model_name'=>'Experimento', 'campo'=>'informacion')); ?>
<br>
<div class="clear: both;"></div>
<div class="col-lg-2 pad-left0 pad-right0">
<a style="cursor: pointer;" onclick="agregar_info_adicional();" class="btn btn-success m-top10"><i class="icon-save"></i> Guardar</a>
</div>
<div class="col-lg-10 pad-left0 pad-right0">
    <div id="error_message" class="alert alert-danger alert-block fade in m-bot0 m-top10" style="display: none;"><i class="icon-warning-sign pull-left m-right10" style="margin-top: 2px;"></i> <div id="message"></div> </div>
</div>
<div style="clear: both;"></div>

<div class="modal fade" id="modal_mas_info_ok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="icon-ok-sign"></i> Información agregada</h4>
            </div>
            <div class="modal-body">
                <strong>La información se ha agregado al experimento correctamente.</strong>
                <br ><br />
                Puede cambiar esta información desde la opción "Editar información"
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-success" type="button">Aceptar</button>
            </div>
        </div>
    </div>
</div>