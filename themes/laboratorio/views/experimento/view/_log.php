<h2 class="subtitle text-info m-top30">
    <i class="icon-sort-by-attributes"></i>
    <strong>Registro de eventos<span class="no-phone"> del experimento</span></strong>
</h2>

<?php if (count($data['logs']) > 0) { ?>
<div class="adv-table m-top20">
    <table class="display table table-bordered table-striped listado logs_por_experimento">
        <thead>
        <tr>
            <th class="center">Fecha</th>
            <th class="center no-mobile">Usuario</th>
            <th class="center no-mobile">Acción</th>
            <th>Descrición</th>
            <th class="no-mobile">Información</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['logs'] as $log) { 
            if ($log->descripcion != '') { ?>
            <tr id="row<?php echo $log->id; ?>">
                <td class="center">
                    <span class="hidden"><?php echo $log->fecha; ?></span>
                    <?php echo $log->fecha_txt; ?>
                </td>
                <td class="center no-mobile"><?php echo $log->nombre_usuario; ?></td>
                <td class="center no-mobile">
                    <i class="<?php echo $log->icono; ?> <?php echo $log->color_icono; ?> fsize150 m-right10"></i>
                    <?php echo $log->accion_txt; ?>
                </td>
                <td>
                    <?php echo $log->descripcion; ?>
                    <?php if ($log->informacion != '') { ?>
                    <div class="only-mobile">
                        <br>
                        <?php echo $log->informacion; ?>
                    </div>
                    <?php } ?>
                    <div style="float: right; display: inline-block;">
                        <i style="margin-top: 2px;" title="<?php echo $log->accion_txt; ?>" class="inline-mobile fsize125 title_in_modal pull-right m-left5 <?php echo $log->icono; ?> <?php echo $log->color_icono; ?>"></i>
                        <i style="margin-top: 2px;" title="Usuario: <?php echo $log->nombre_usuario; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-user m-left5"></i>
                    </div>
                </td>
                <td class="no-mobile"><?php echo $log->informacion; ?></td>
            </tr>
        <?php } 
        } ?>
        </tbody>   
    </table>
</div>
 <?php } ?>