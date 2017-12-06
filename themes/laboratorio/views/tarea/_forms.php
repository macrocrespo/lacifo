<a id="btn_agregar_tarea" onclick="agregar_tarea_form();" class="btn btn-success btn-sm" style="color: #fff;">
    <i class="icon-plus-sign-alt"></i> Agregar tarea
</a>

<div id="agregar_tarea_wrapper" style="display: none;">
    <h2 class="subtitle text-success m-top0">
        <i class="icon-plus-sign-alt"></i>
        <strong>Agregar tarea</strong>
    </h2>
    <br>
    
    <form id="agregar_tarea_form">
        <strong style="display: block;" class="m-bot5">Título</strong>
        <input class="form-control m-bot20" maxlength="100" name="Tarea[titulo]" id="Tarea_titulo" type="text">

        <span style="display: block;" class="m-bot10"><strong>Descripción</strong> (Opcional)</span>
        <?php $this->widget('Textarea', array('model_name'=>'Tarea', 'campo'=>'descripcion')); ?>
        <br>

        <strong style="display: block;" class="m-bot5">Asignar a</strong>
        <select class="form-control input-sm" name="Tarea[asignar_a]" id="Tarea_asignar_a">
            <option value="0">Mi</option>
            <?php foreach ($data['usuarios'] as $u) { $usuario = (object) $u; ?>
            <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre; ?></option>
            <?php } ?>
        </select>
        <br>

        <div class="col-lg-12 pad-left0 pad-right0">
            <div class="col-lg-3 pad-left0 pad-right0">
                <a style="cursor: pointer;" onclick="cancelar_agregar_tarea();" class="btn btn-danger pull-left m-right10 m-bot5"><i class="icon-ban-circle"></i> Cancelar</a>
                <a style="cursor: pointer;" onclick="agregar_tarea();" class="btn btn-success pull-left m-bot5"><i class="icon-save"></i> Guardar</a>
                <div style="clear: both;"></div>
            </div>
            <div class="col-lg-9 pad-left0 pad-right0">
                <div id="error_message" class="alert alert-warning alert-block fade in m-bot0"><i class="icon-warning-sign pull-left m-right10" style="margin-top: 2px;"></i> <div id="message"></div> </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </form>
</div>

<div id="editar_tarea_wrapper" style="display: none;">
    <h2 class="subtitle text-success m-top0">
        <i class="icon-edit-sign"></i>
        <strong>Editar tarea</strong>
    </h2>
    <br>
    
    <form id="editar_tarea_form">
        <strong style="display: block;" class="m-bot5">Título</strong>
        <input class="form-control m-bot20" maxlength="100" name="Tarea[titulo_editar]" id="Tarea_titulo_editar" type="text" value="">

        <span style="display: block;" class="m-bot10"><strong>Descripción</strong> (Opcional)</span>
        <?php $this->widget('Textarea', array('model_name'=>'Tarea', 'campo'=>'descripcion_editar')); ?>
        <br>

        <strong style="display: block;" class="m-bot5">Asignar a</strong>
        <select class="form-control input-sm" name="Tarea[asignar_a_editar]" id="Tarea_asignar_a_editar">
            <option value="0">Mi</option>
            <?php foreach ($data['usuarios'] as $u) { $usuario = (object) $u; ?>
            <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre; ?></option>
            <?php } ?>
        </select>
        <br>

        <div class="col-lg-12 pad-left0 pad-right0">
            <div class="col-lg-3 pad-left0 pad-right0">
                <a style="cursor: pointer;" onclick="cancelar_editar_tarea();" class="btn btn-danger pull-left m-right10 m-bot5"><i class="icon-ban-circle"></i> Cancelar</a>
                <a style="cursor: pointer;" onclick="editar_tarea();" class="btn btn-success pull-left m-bot5"><i class="icon-save"></i> Guardar</a>
                <div style="clear: both;"></div>
            </div>
            <div class="col-lg-9 pad-left0 pad-right0">
                <div id="error_message_editar" class="alert alert-warning alert-block fade in m-bot0"><i class="icon-warning-sign pull-left m-right10" style="margin-top: 2px;"></i> <div id="message_editar"></div> </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </form>
</div>