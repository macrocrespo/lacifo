<?php if ($cantidad['TOTAL'] > 0) { ?>

<?php $this->beginWidget('Panel'); ?>

    <div class="row state-overview">
        <div class="col-lg-3 col-sm-6">
            <section class="panel light-grey no-border-all m-bot5 m-top5">
                <a title="Ver experimentos Iniciados" onclick="ver_experimentos_por_estado('INICIADO');">
                    <div class="symbol bg-INICIADO">
                        <i class="<?php echo $icono['INICIADO']; ?>"></i>
                    </div>
                </a>
                <div class="value">
                    <h1 class="count">
                        <?php echo $cantidad['INICIADO']; ?>
                    </h1>
                    <p>Iniciado<?php if ($cantidad['INICIADO'] != 1) { echo 's'; } ?></p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel light-grey no-border-all m-bot5 m-top5">
                <a title="Ver experimentos Preparados" onclick="ver_experimentos_por_estado('PREPARADO');">
                    <div class="symbol bg-PREPARADO">
                        <i class="<?php echo $icono['PREPARADO']; ?>"></i>
                    </div>
                </a>
                <div class="value">
                    <h1 class=" count2">
                        <?php echo $cantidad['PREPARADO']; ?>
                    </h1>
                    <p>Preparado<?php if ($cantidad['PREPARADO'] != 1) { echo 's'; } ?></p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel light-grey no-border-all m-bot5 m-top5">
                <a title="Ver experimentos En curso" onclick="ver_experimentos_por_estado('EN_CURSO');">
                    <div class="symbol bg-EN_CURSO">
                        <i class="<?php echo $icono['EN_CURSO']; ?>"></i>
                    </div>
                </a>
                <div class="value">
                    <h1 class=" count3">
                        <?php echo $cantidad['EN_CURSO']; ?>
                    </h1>
                    <p>En curso</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel light-grey no-border-all m-bot5 m-top5">
                <a title="Ver experimentos Finalizados" onclick="ver_experimentos_por_estado('FINALIZADO');">
                    <div class="symbol bg-FINALIZADO">
                        <i class="<?php echo $icono['FINALIZADO']; ?>"></i>
                    </div>
                </a>
                <div class="value">
                    <h1 class=" count4">
                        <?php echo $cantidad['FINALIZADO']; ?>
                    </h1>
                    <p>Finalizado<?php if ($cantidad['FINALIZADO'] != 1) { echo 's'; } ?></p>
                </div>
            </section>
        </div>
        <div style="clear: both;"></div>
        <div class="col-sm-12" id="btn-reset-estados-wrapper" style="display: none;">
            <a onclick="reset_estados();" class="btn btn-danger m-top10 btn-sm" style="color: #fff;">
                Cancelar
            </a>
        </div>
    </div>

<?php $this->endWidget(); ?>

<?php } ?>