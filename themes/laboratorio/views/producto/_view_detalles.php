<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left" style="font-size: 1.2em;">
        <i class="icon-beaker"></i>
        <strong><?php echo $model->nombre; ?></strong>
    </h5>
    <div style="clear: both;"></div>
</div>

<div class="col-md-3 col-lg-3 summary-list-item bg-light-grey shadow-light-grey round-left" style="border-right: 1px solid #eaeaea;">
    <ul class="summary-list">
        <li class="w100">
            <a href="javascript:;">
                <i class="icon-compass text-primary fsize200"></i>
                Marca <?php echo $model->marca; ?>
            </a>
        </li>
    </ul>
</div>
<div class="col-md-3 col-lg-3 summary-list-item bg-light-grey shadow-light-grey" style="border-right: 1px solid #eaeaea;">
    <ul class="summary-list">
        <li class="w100">
            <a title="Ver detalles" href="<?php echo Yii::app()->request->baseUrl.'/rubro/'.$model->rubro; ?>">
                <i class=" icon-bookmark text-warning fsize200"></i>
                Rubro <?php echo $rubro->nombre; ?>
            </a>
        </li>
    </ul>
</div>
<div class="col-md-3 col-lg-3 summary-list-item bg-light-grey shadow-light-grey round-right">
    <ul class="summary-list">
        <li class="w100">
            <a title="Ver detalles" href="<?php echo Yii::app()->request->baseUrl.'/tipo_producto/'.$model->tipo_producto_id; ?>">
                <i class=" icon-tags text-primary fsize200"></i>
                Tipo <?php echo $model->tipo_producto->nombre; ?>
            </a>
        </li>
    </ul>
</div>
<div class="col-md-3 col-lg-3 summary-list-item bg-light-grey shadow-light-grey round-right">
    <ul class="summary-list">
        <li class="w100">
            <a href="javascript:;">
                <i class=" icon-flag text-<?php echo ($model->estado) ? 'success' : 'danger'; ?> fsize200"></i>
                Estado <?php echo ($model->estado) ? 'Activo' : 'Inactivo'; ?>
            </a>
        </li>
    </ul>
</div>
<div style="clear: both;" class="mbot30"></div>

<table class="detail-view table table-striped table-condensed">
    <tbody>
        <tr class="odd"><th>Nombre</th><td><?php echo $model->nombre; ?></td></tr>
        <tr class="even"><th>Nombre en inglés</th><td><?php echo $model->nombre_ingles; ?></td></tr>
        <tr class="odd"><th>Descripción</th><td><?php echo $model->descripcion; ?></td></tr>
        <tr class="even"><th>IUPAC#</th><td><span class="null"><?php echo $model->IUPAC; ?></span></td></tr>
        <tr class="odd"><th>CAS</th><td><span class="null"><?php echo ($model->CAS != '') ? $model->CAS : 'No asignado'; ?></span></td></tr>
    
        <?php if (isset($producto_detalle)) { ?>
        <tr class="even"><th>Fracción</th><td><span class="null"><?php echo ($producto_detalle->fraccion != '') ? $producto_detalle->fraccion : 'No asignado'; ?></span></td></tr>
        <tr class="odd"><th>Unidad de medida</th><td><span class="null"><?php echo ($producto_detalle->unidad_medida != '') ? $producto_detalle->unidad_medida : 'No asignado'; ?></span></td></tr>
        <tr class="even"><th>Fórmula Química</th><td><span class="null"><?php echo ($producto_detalle->formula_quimica != '') ? $producto_detalle->formula_quimica : 'No asignado'; ?></span></td></tr>
        <tr class="odd"><th>Peso Molecular</th><td><span class="null"><?php echo ($producto_detalle->peso_molecular != '') ? $producto_detalle->peso_molecular : 'No asignado'; ?></span></td></tr>
        <tr class="even"><th>Laboratorio</th><td><span class="null"><?php echo ($producto_detalle->laboratorio != '') ? $producto_detalle->laboratorio : 'No asignado'; ?></span></td></tr>
        <?php } ?>
    </tbody>
</table>

<h2 class="subtitle text-info m-top30">
    <i class="icon-map-marker"></i>
    <strong>Ubicación</strong>
</h2>
<table class="detail-view table table-striped table-condensed">
    <tbody>
        <tr class="odd"><th>Depósito</th>
            <td>
                <a title="Ver detalles" href="<?php echo Yii::app()->request->baseUrl.'/deposito/'.$deposito->id; ?>">
                <?php echo $deposito->nombre; ?>
                </a>
            </td>
        </tr>
        <tr class="even"><th>Contenedor</th>
            <td>
                <a title="Ver detalles" href="<?php echo Yii::app()->request->baseUrl.'/contenedor/'.$model->contenedor_id; ?>">
                <?php echo $model->contenedor->nombre; ?>
                </a>
            </td>
        </tr>
    </tbody>
</table>

<h2 class="subtitle text-info m-top30">
    <i class="icon-beaker"></i>
    <strong>Stock</strong>
</h2>


<div class="col-sm-3">
    <div class="row state-overview">
        <section class="panel light-grey no-border-all">
            <div class="symbol <?php echo $stock_data->color; ?>">
                <i class="icon-beaker"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    <?php echo $stock->cantidad; ?>
                </h1>
                <p>Cantidad actual</p>
            </div>
        </section>
    </div>
</div>

<div class="col-sm-9 no-padding-mobile">
    <table class="detail-view table table-striped table-condensed">
        <tbody>
            <tr class="odd"><th>Mínimo</th><td><?php echo $stock->minimo; ?></td></tr>
            <tr class="even"><th>Máximo</th><td><?php echo $stock->maximo; ?></td></tr>
            <tr class="odd"><th>Sugerido</th><td><?php echo $stock->sugerido; ?></td></tr>
        </tbody>
    </table>
</div>

<?php if ($stock_data->warning) { ?>
<div style="clear: both;"></div>
<div id="error_stock" class="alert alert-block alert-warning fade in m-bot-none" style="display: block;">
    <div id="message"><i class="icon-warning-sign"></i> La cantidad actual es menor a la sugerida, se recomienda aumentar el stock de este producto en lo posible.</div>
</div>
<?php } ?>
<?php if ($stock_data->error) { ?>
<div style="clear: both;"></div>
<div id="error_stock" class="alert alert-block alert-danger fade in m-bot-none" style="display: block;">
    <div id="message"><i class="icon-warning-sign"></i> 
        <?php if ($stock->cantidad == 0) { ?>
        No hay stock de este producto, para poder utilizarlo, se debe aumentar el stock de este producto urgente.
        <?php } else { ?>
        La cantidad actual es menor a la mínima, se debe aumentar el stock de este producto urgente.
        <?php } ?>
    </div>
</div>
<?php } ?>