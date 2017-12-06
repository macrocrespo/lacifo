<?php if (count($experimentos) > 0) { ?>
<?php $url_controller = Yii::app()->request->baseUrl.'/experimento'; ?>
<div class="adv-table">
    <table class="display table table-bordered table-striped listado">
        <thead>
        <tr>
            <th class="hidden-xs">Fecha de creación</th>
            <th>Título</th>
            <th class="hidden-xs">Creado por</th>
            <th class="center">Estado y Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($experimentos as $r) { $r = (object) $r; ?>
        <tr>
            <td class="hidden-xs">
                <span class="hidden"><?php echo $r->fecha; ?></span>
                <?php echo $this->fecha_formato_listado($r->fecha); ?>
            </td>
            <td>
                <span style="display: inline-block; float: left;"><?php echo $r->titulo; ?></span>
                <div style="display: inline-block; float: right;">
                    <i title="Fecha de creación: <?php echo $this->fecha_formato_listado($r->fecha); ?>" class="only-mobile icon-time fsize125 title_in_modal pull-left m-left10"></i>
                    <i title="Creado por: <?php echo $usuarios[$r->usuario_id]; ?>" class="only-mobile icon-user fsize125 title_in_modal pull-left"></i>
                </div>
                <div style="clear: both;"></div>
            </td>
            <td class="hidden-xs"><?php echo $usuarios[$r->usuario_id]; ?></td>
            <td class="center" style="padding-top: 5px; padding-bottom: 2px;">
                <?php switch ($r->estado) {
                    case 'INICIADO':    $status_class = 'primary';  $status_label = 'Iniciado';     $status_priority = 'a'; $status_icon = 'icon-home';         break;
                    case 'PREPARADO':   $status_class = 'warning';  $status_label = 'Preparado';    $status_priority = 'b'; $status_icon = 'icon-puzzle-piece'; break;
                    case 'EN_CURSO':    $status_class = 'info';     $status_label = 'En curso';     $status_priority = 'c'; $status_icon = 'icon-cog';          break;
                    case 'FINALIZADO':  $status_class = 'success';  $status_label = 'Finalizado';   $status_priority = 'd'; $status_icon = 'icon-flag';         break;
                } ?>
                <span class="hidden"><?php echo $status_priority; ?></span>
                <div class="btn-group">
                    <button type="button" class="btn btn-<?php echo $status_class; ?> btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="<?php echo $status_icon; ?>"></i> 
                        <?php echo $status_label; ?>
                        <span class="caret"></span> 
                    </button>

                    <?php if ($r->estado == 'INICIADO') { ?>
                        <ul class="dropdown-menu" style="min-width: auto; font-size: 13px;">
                            <li><a href="<?php echo $url_controller.'/view/'.$r->id; ?>">Detalles</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $url_controller.'/update/'.$r->id; ?>">Información inicial</a></li>
                            <li><a href="<?php echo $url_controller.'/agregarProductos/'.$r->id; ?>">Agregar productos</a></li>
                            <li><a href="<?php echo $url_controller.'/cargarSeries/'.$r->id; ?>">Cargar series</a></li>
                            <li><a href="<?php echo $url_controller.'/agregarEquipos/'.$r->id; ?>">Agregar equipos</a></li>
                            <li><a href="<?php echo $url_controller.'/verificarInformacion/'.$r->id; ?>">Verificar información</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $url_controller.'/cambiarEstado/'.$r->id; ?>">Cambiar estado</a></li>
                            <li><a href="<?php echo $url_controller.'/informacionAdicional/'.$r->id; ?>">Información adicional</a></li>
                        </ul>
                    <?php } ?>

                    <?php if ($r->estado == 'PREPARADO' || $r->estado == 'EN_CURSO') { ?>
                        <ul class="dropdown-menu" style="min-width: auto; font-size: 13px;">
                            <li><a href="<?php echo $url_controller.'/view/'.$r->id; ?>">Detalles</a></li>
                            <li><a href="<?php echo $url_controller.'/update/'.$r->id; ?>">Editar</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo $url_controller.'/cambiarEstado/'.$r->id; ?>">Cambiar estado</a></li>
                            <li><a href="<?php echo $url_controller.'/informacionAdicional/'.$r->id; ?>">Información adicional</a></li>
                        </ul>
                    <?php } ?>

                    <?php if ($r->estado == 'FINALIZADO') { ?>
                        <ul class="dropdown-menu" style="min-width: auto; font-size: 13px;">
                            <li><a href="<?php echo $url_controller.'/view/'.$r->id; ?>">Detalles</a></li>
                        </ul>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.listado').dataTable( {
        /* "bFilter": false // Quitar el filtro */
    });
    $('.title_in_modal').each(function(){
        $(this).attr('onclick', 'show_title_in_modal(this)');
    });
});
</script>
<?php } else {

$this->widget('Mensaje', array(
    'mensaje'   => 'Este producto no se ha utilizado en ningún experimento.',
    'type'      => 'warning',
    'show_icon' => true,
    'close'     => false
));

} ?>
