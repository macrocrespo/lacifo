<?php if (count($productos) > 0) { ?>
    <?php $url_controller = Yii::app()->request->baseUrl.'/'.$this->controller; ?>
    <div class="adv-table">
        <table class="display table table-bordered table-striped listado">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th class="no-phone no-tablet">Descripción</th>
                <th class="no-phone">Marca</th>
                <th class="no-phone">Tipo</th>
                <th class="center" style="width: 90px;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $r) { $r = (object) $r; ?>
            <tr>
                <td><?php echo $r->id; ?></td>
                <td>
                    <span title="<?php echo $r->descripcion; ?>" style="display: inline-block; float: left;"><?php echo $r->nombre; ?></span>
                    <?php 
                    $txt = ($r->marca != '') ? 'Marca: '.$r->marca.'. ' : '';
                    $txt .= 'Tipo: '.$r->tipo;
                    ?>
                    <i title="<?php echo $txt; ?>" class="only-phone icon-beaker fsize125 title_in_modal pull-right title_in_modal"></i>
                </td>
                <td class="no-phone no-tablet"><?php echo $r->descripcion; ?></td>
                <td class="no-phone"><?php echo $r->marca; ?></td>
                <td class="no-phone"><?php echo $r->tipo; ?></td>

                <td class="center" style="padding-top: 5px; padding-bottom: 5px;">
                    
                    <div class="btn-group">
                        <a title="Detalles" class="btn btn-xs btn-primary" href="<?php echo $url_controller.'/view/'.$r->id; ?>">
                            <i class="icon-info-sign"></i>
                        </a>
                        <a title="Editar" class="btn btn-xs btn-warning" href="<?php echo $url_controller.'/update/'.$r->id; ?>">
                            <i class="icon-edit"></i>
                        </a>
                        <a title="Eliminar" class="btn btn-xs btn-danger" style="cursor: pointer;" onClick="confirmar_eliminar_producto(<?php echo $r->id; ?>);">
                            <i class="icon-trash"></i>
                        </a>
                    </div>
                    
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $('.listado').dataTable({
            /* "bFilter": false // Quitar el filtro */
            "bAutoWidth": false,
            "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 5 ] }]
        });

        $('.title_in_modal').each(function(){
            $(this).attr('onclick', 'show_title_in_modal(this)');
        });
    });
    </script>
<?php } else {

$this->widget('Mensaje', array(
    'mensaje'   => 'Aún no se han cargado productos en el sistema.',
    'type'      => 'warning',
    'show_icon' => true,
    'close'     => false
));

} ?>
