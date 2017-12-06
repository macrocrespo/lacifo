<?php $experimento = (object) $model; ?>
<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left">
        <i class="icon-tags"></i>
        <strong>Series</strong>
    </h5>
    <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller.'/cargarSeries/'.$experimento->id; ?>" class="btn btn-success pull-right "><i class="icon-pencil"></i> Editar</a>
    <div style="clear: both;"></div>
</div>

<?php if (count($data['series']) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado series_por_experimento">
        <thead>
        <tr>
            <th>Serie</th>
            <th>Vencimiento</th>
            <th class="no-mobile">Código del producto</th>
            <th class="no-mobile">Nombre del producto</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['series'] as $s) { $s = (object) $s; ?>
        <tr id="row<?php echo $s->serie; ?>">
            <td>
                <?php echo $s->serie; ?>
                <i style="margin-top: 2px; display: inline-block;" title="Producto <?php echo $s->id; ?>: <?php echo $s->nombre; ?>." class="inline-mobile fsize125 title_in_modal pull-right icon-beaker m-left5"></i>
            </td>
            <td>
                <span class="hidden"><?php echo $s->vencimiento; ?></span>
                <?php echo $this->fecha_formato_listado($s->vencimiento, 1); ?>
            </td>
            <td class="no-mobile"><?php echo $s->id; ?></td>
            <td class="no-mobile"><?php echo $s->nombre; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php } else {     
    $url = Yii::app()->request->baseUrl.'/'.$this->controller.'/cargarSeries/'.$model->id;
    $this->widget('Mensaje', array(
        'mensaje'   => 'No se han asignado series al experimento. Para asignar series, <a style="cursor: pointer;" href="'.$url.'">click aquí</a>.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));
} ?>
