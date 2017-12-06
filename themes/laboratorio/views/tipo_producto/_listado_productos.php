<?php if (count($productos) > 0) { ?>
    <?php $url_controller = Yii::app()->request->baseUrl.'/producto'; ?>
    <div class="adv-table">
        <table class="display table table-bordered table-striped listado">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th class="no-phone no-tablet">Descripción</th>
                <th class="no-phone">Marca</th>
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
                    ?>
                    <i title="<?php echo $txt; ?>" class="only-phone icon-beaker fsize125 title_in_modal pull-right title_in_modal"></i>
                </td>
                <td class="no-phone no-tablet"><?php echo $r->descripcion; ?></td>
                <td class="no-phone"><?php echo $r->marca; ?></td>

                <td class="center" style="padding-top: 5px; padding-bottom: 5px;">
                    
                    <div class="btn-group">
                        <a title="Detalles" class="btn btn-xs btn-primary" href="<?php echo $url_controller.'/view/'.$r->id; ?>">
                            <i class="icon-info-sign"></i>
                        </a>
                        <a title="Editar" class="btn btn-xs btn-warning" href="<?php echo $url_controller.'/update/'.$r->id; ?>">
                            <i class="icon-edit"></i>
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
            "aoColumnDefs": [{ "bSortable": false, "aTargets": [ 4 ] }]
        });

        $('.title_in_modal').each(function(){
            $(this).attr('onclick', 'show_title_in_modal(this)');
        });
    });
    </script>
<?php } else {

$this->widget('Mensaje', array(
    'mensaje'   => 'No se han cargado productos para este tipo.',
    'type'      => 'warning',
    'show_icon' => true,
    'close'     => false
));

} ?>
