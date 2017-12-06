<?php $experimento = (object) $model; ?>

<h2 class="subtitle text-info">
    <i class="icon-rocket"></i>
    <strong>Equipos</strong>
</h2>

<?php if (count($data['equipos']) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado equipos_por_experimento">
        <thead>
        <tr>
            <th>Nombre</th>
            <th class="no-phone">Marca</th>
            <th class="no-mobile">Observaciones</th>
            <th class="center">Estado</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['equipos'] as $e) { $e = (object) $e; ?>
        <tr id="row<?php echo $e->id; ?>">
            <td>
                <?php echo $e->nombre; ?>
                <?php $marca_txt = ($e->marca != '') ? 'Marca: '.$e->marca.'. ' : ''; ?>
                <i style="margin-top: 2px; display: inline-block;" title="<?php echo $marca_txt.$e->observaciones; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-info-sign m-left5"></i>
            </td>
            <td class="no-phone"><?php echo $e->marca; ?></td>
            <td class="no-mobile"><?php echo $e->observaciones; ?></td>
            <td class="center"><?php echo $e->estado; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php } else {     
    $url = Yii::app()->request->baseUrl.'/'.$this->controller.'/agregarEquipos/'.$model->id;
    $this->widget('Mensaje', array(
        'mensaje'   => 'No se han agregado equipos al experimento. Para agregar equipos, <a style="cursor: pointer;" href="'.$url.'">click aquí</a>.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));
} ?>

