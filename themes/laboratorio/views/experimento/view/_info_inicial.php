<?php $experimento = (object) $model; ?>

<?php echo $data['info_basica']; ?>

<h2 class="subtitle text-info">
    <i class="icon-double-angle-right"></i>
    <strong>Descripción</strong>
</h2>
<div class="information_block">
    <?php echo $experimento->descripcion; ?>
</div>
<div style="clear: both;" class="m-bot30"></div>

<h2 class="subtitle text-info">
    <i class="icon-double-angle-right"></i>
    <strong>Condiciones</strong>
</h2>
<div class="information_block">
    <?php echo $experimento->condiciones; ?>
</div>
<div style="clear: both;" class="m-bot30"></div>

<h2 class="subtitle text-info">
    <i class="icon-double-angle-right"></i>
    <strong>Resultados</strong>
</h2>
<div class="information_block">
    <?php echo $experimento->resultados; ?>
</div>
<div style="clear: both;" class="m-bot30"></div>

<a style="cursor: pointer; display: inline-block;" onclick="$('#tab2 a').click(); goto('panel-detalles', 1);" class="btn-sm btn-info m-right5 m-bot10"><i class="icon-beaker"></i> Productos y equipos</a>
<a style="cursor: pointer; display: inline-block;" onclick="$('#tab3 a').click(); goto('panel-detalles', 1);" class="btn-sm btn-info m-bot10"><i class="icon-info-sign"></i> Más información</a>
<div style="clear: both;"></div>
