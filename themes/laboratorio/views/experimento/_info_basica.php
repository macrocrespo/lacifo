<?php if ($data['titulo'] != '') { ?>

<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left" style="font-size: 1.2em;">
        <i class="icon-lightbulb"></i>
        <strong><?php echo $data['titulo']; ?></strong>
    </h5>
    <a href="<?php echo Yii::app()->request->baseUrl.'/experimento/view/'.$data['id']; ?>" class="btn-success btn btn-sm pull-right m-top5"><i class="icon-double-angle-right"></i> Ver detalles</a>
    <div style="clear: both;"></div>
</div>
<?php } ?>

<div class="col-md-4 col-lg-4 summary-list-item bg-light-grey shadow-light-grey round-left" style="border-right: 1px solid #eaeaea;">
    <ul class="summary-list">
        <li class="w100">
            <a href="javascript:;">
                <i class="<?php echo $data['estado_icono']; ?> text-primary fsize200"></i>
                Estado <?php echo $data['estado_txt']; ?>
            </a>
        </li>
    </ul>
</div>
<div class="col-md-4 col-lg-4 summary-list-item bg-light-grey shadow-light-grey" style="border-right: 1px solid #eaeaea;">
    <ul class="summary-list">
        <li class="w100">
            <a href="javascript:;">
                <i class=" icon-time text-warning fsize200"></i>
                Creado el <?php echo $data['fecha_creacion']; ?>
            </a>
        </li>
    </ul>
</div>
<div class="col-md-4 col-lg-4 summary-list-item bg-light-grey shadow-light-grey round-right">
    <ul class="summary-list">
        <li class="w100">
            <a href="javascript:;">
                <i class=" icon-user text-success fsize200"></i>
                Creado por <?php echo $data['nombre_usuario']; ?>
            </a>
        </li>
    </ul>
</div>
<div style="clear: both;" class="mbot30"></div>