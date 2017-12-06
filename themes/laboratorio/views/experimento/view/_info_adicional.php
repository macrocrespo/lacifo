<?php $experimento = (object) $model; ?>
<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left" style="font-size: 1.2em;">
        <i class="icon-lightbulb"></i>
        <strong><?php echo $experimento->titulo; ?></strong>
    </h5>
    <div style="clear: both;"></div>
</div>

<?php if (count($data['info_adicional']) > 0) { ?>
<h2 class="subtitle text-info m-top30">
    <i class="icon-info-sign"></i>
    <strong>Información adicional<span class="no-phone"> del experimento</span></strong>
</h2>

<div class="timeline-messages">
    
    <?php foreach ($data['info_adicional'] as $info) { $info = (object) $info; ?>
    <div class="msg-time-chat">
        <a class="message-img"><i title="Estado <?php echo $info->estado_txt; ?>" class="<?php echo $info->estado_icono; ?>"></i></a>
        <div class="message-body msg-in">
            <span class="arrow"></span>
            <div class="text">
                <p class="attribution text-warning m-bot10">Información cargada el <?php echo str_replace(' ', ' a las ', $info->fecha_txt); ?> por <?php echo $info->nombre_usuario; ?></p>
                <?php echo $info->mas_info; ?>
            </div>
        </div>
    </div>
    <?php } ?>
    
</div>
<?php } ?>
