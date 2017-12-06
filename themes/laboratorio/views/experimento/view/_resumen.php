<?php $experimento = (object) $model; ?>
<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left" style="font-size: 1.2em;">
        <i class="icon-lightbulb"></i>
        <strong><?php echo $experimento->titulo; ?></strong>
    </h5>
    <div style="clear: both;"></div>
</div>

<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="panel light-grey no-border-all">
            <div class="symbol terques">
                <i class="icon-beaker"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    <?php echo count($data['productos']); ?>
                </h1>
                <p>Producto<?php if (count($data['productos']) != 1) { echo 's'; } ?></p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel light-grey no-border-all">
            <div class="symbol yellow">
                <i class="icon-tags"></i>
            </div>
            <div class="value">
                <h1 class=" count2">
                    <?php echo count($data['series']); ?>
                </h1>
                <p>Serie<?php if (count($data['series']) != 1) { echo 's'; } ?></p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel light-grey no-border-all">
            <div class="symbol red">
                <i class="icon-rocket"></i>
            </div>
            <div class="value">
                <h1 class=" count3">
                    <?php echo count($data['equipos']); ?>
                </h1>
                <p>Equipo<?php if (count($data['equipos']) != 1) { echo 's'; } ?></p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="panel light-grey no-border-all">
            <div class="symbol blue">
                <i class="icon-bar-chart"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    $<?php echo round($experimento->total,0); ?>
                </h1>
                <p>Total consumido</p>
            </div>
        </section>
    </div>
</div>
