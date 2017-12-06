<?php if (count($data['info_adicional']) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado info_adicional_experimento">
        <thead>
        <tr>
            <th class="center">Fecha</th>
            <th class="center no-mobile">Usuario</th>
            <th class="center no-mobile">Estado</th>
            <th>Información</th>
            <th class="center">
                <span class="no-phone">Acciones</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['info_adicional'] as $info) { $info = (object) $info; ?>
        <tr id="row<?php echo $info->id; ?>">
            <td class="center">
                <span class="hidden"><?php echo $info->fecha; ?></span>
                <?php echo $info->fecha_txt; ?>
            </td>
            <td class="center no-mobile"><?php echo $info->nombre; ?></td>
            <td class="center no-mobile"><?php echo $info->estado_txt; ?></td>
            <td>
                <?php echo $info->mas_info; ?>
                <div style="display: inline-block; margin-top: 2px; float: right;">
                    <i style="margin-top: 2px; display: inline-block;" title="Estado: <?php echo $info->estado_txt; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-map-marker m-left10"></i>
                    <i style="margin-top: 2px; display: inline-block;" title="Usuario: <?php echo $info->nombre; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-user m-left10"></i>
                </div>
            </td>
            <td class="center" style="width: 110px;">
                <?php if ($info->estado_experimento == $info->estado) { ?>
                <a style="cursor: pointer;" onclick="editar_info_adicional_form(<?php echo $info->id; ?>)" class="btn btn-xs btn-warning m-left5" title="Editar"><i class="icon-pencil"></i></a>
                <a style="cursor: pointer;" onclick="confirmar_eliminar(<?php echo $info->id; ?>)" class="btn btn-xs btn-danger m-left5" title="Eliminar"><i class="icon-remove"></i></a>
                <?php } else { ?>
                <a class="btn btn-xs btn-info" title="No se puede modificar la información que se ha cargado en otro estado"><i class="icon-info" style="font-size: 14px; padding: 2px 3px;"></i></a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="confirmar_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                ¿ Esta seguro que desea eliminar la información adicional del experimento ?
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-danger" onclick="eliminar_info_adicional();" type="button">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<?php $theme_url = Yii::app()->theme->baseUrl.'/'; ?>
<script type="text/javascript" language="javascript" src="<?php echo $theme_url; ?>assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.listado').dataTable({
        "bAutoWidth": false,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 3,4 ] }]
    });
});
</script>

<?php } else {
    $this->widget('Mensaje', array(
        'mensaje'   => 'No se ha agregado información adicional al experimento. Para agregar información, <a onClick="$(\'#tab1 a\').click(); goto(\'titulo_agregar\', 1);" style="cursor: pointer;">click aquí</a>.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));
} ?>