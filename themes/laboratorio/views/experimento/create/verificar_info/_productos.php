<?php $experimento = (object) $model; ?>
<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left">
        <i class="icon-beaker"></i>
        <strong>Productos</strong>
    </h5>
    <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller.'/agregarProductos/'.$experimento->id; ?>" class="btn btn-success pull-right "><i class="icon-pencil"></i> Editar</a>
    <div style="clear: both;"></div>
</div>

<?php if (count($data['productos']) > 0) { ?>
<div class="adv-table m-top20">
    <table  class="display table table-bordered table-striped listado productos_por_experimento">
        <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th class="no-mobile">Tipo</th>
            <th class="no-mobile center">Usa serie</th>
            <th class="center">Cantidad</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['productos'] as $p) { $p = (object) $p; ?>
        <tr id="row<?php echo $p->id; ?>">
            <td><?php echo $p->id; ?></td>
            <td>
                <a title="Ver detalles" href="<?php echo Yii::app()->request->baseUrl.'/producto/'.$p->id; ?>">
                <?php echo $p->nombre; ?>
                </a>
                <?php $txt_serie = ($p->producto_usa_serie) ? '. Se deben cargar series.' : ''; ?>
                <i style="margin-top: 2px; display: inline-block;" title="Tipo: <?php echo $p->tipo.$txt_serie; ?>" class="inline-mobile fsize125 title_in_modal pull-right icon-info-sign m-left5"></i>
            </td>
            <td class="no-mobile"><?php echo $p->tipo; ?></td>
            <td class="no-mobile center">
                <?php if($p->producto_usa_serie) { ?>
                <span class="hidden">a</span>
                <i title="Este producto carga series" class="icon-ok-sign text-success" style="font-size: 18px;"></i>
                <?php } else { ?>
                <span class="hidden">b</span>
                <i title="Este producto no carga series" class="icon-minus-sign text-default" style="font-size: 18px;"></i>
                <?php } ?>
            </td>
            <td class="center"><?php echo $p->cantidad; ?>
                <?php if ($p->fraccion != '') { ?>
                x <?php echo $p->fraccion; ?><?php echo $p->unidad_medida; ?>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php } else {     
    $url = Yii::app()->request->baseUrl.'/'.$this->controller.'/agregarProductos/'.$model->id;
    $this->widget('Mensaje', array(
        'mensaje'   => 'No se han agregado productos al experimento. Para agregar productos, <a style="cursor: pointer;" href="'.$url.'">click aquí</a>.',
        'type'      => 'warning',
        'show_icon' => true,
        'close'     => false
    ));

} ?>

