<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Confirmación'
        ), 'separator' => ''
    )); ?>
</div>

<?php $mensaje = $data['mensaje']; ?>
<div class="col-lg-12">
    <section class="panel">
        <div class="panel-body">
            <div class="alert alert-success alert-block fade in">
                <h5 class="pull-left" style="font-size: 1.2em;">
                    <i class="<?php echo $mensaje->icono; ?>"></i>
                    <strong><?php echo $mensaje->titulo; ?></strong>
                </h5>
                <div style="clear: both;"></div>
            </div>
            <div class="form-actions text-center">
                <span class="m-right20">Opciones disponibles: </span>
                <?php foreach ($mensaje->opciones as $opcion) { ?>
                
                    <?php if ($opcion == 'agregar_productos') { ?>
                    <a href="/lacifo/experimento/agregarProductos/<?php echo $model->id; ?>" class="btn-primary btn m-right5 m-top5 btn-sm"><i class="icon-beaker"></i> Agregar productos</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'cargar_series') { ?>
                    <a href="/lacifo/experimento/cargarSeries/<?php echo $model->id; ?>" class="btn-primary btn m-right5 m-top5 btn-sm"><i class="icon-tags"></i> Cargar series</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'agregar_equipos') { ?>
                    <a href="/lacifo/experimento/agregarEquipos/<?php echo $model->id; ?>" class="btn-primary btn m-right5 m-top5 btn-sm"><i class="icon-rocket"></i> Agregar equipos</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'verificar_informacion') { ?>
                    <a href="/lacifo/experimento/verificarInformacion/<?php echo $model->id; ?>" class="btn-primary btn m-right5 m-top5 btn-sm"><i class="icon-ok-sign"></i> Verificar información</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'experimentos') { ?>
                    <a href="/lacifo/experimento" class="btn-success btn m-right5 m-top5 btn-sm"><i class="icon-lightbulb"></i> Ir a experimentos</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'detalles') { ?>
                    <a href="/lacifo/experimento/view/<?php echo $model->id; ?>" class="btn-primary btn m-right5 m-top5 btn-sm"><i class="icon-double-angle-right"></i> Ver detalles</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'volver_editar') { ?>
                    <a href="/lacifo/experimento/update/<?php echo $model->id; ?>" class="btn-danger btn m-right5 m-top5 btn-sm"><i class="icon-chevron-left"></i> Volver a editar</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'volver_productos') { ?>
                    <a href="/lacifo/experimento/agregarProductos/<?php echo $model->id; ?>" class="btn-danger btn m-right5 m-top5 btn-sm"><i class="icon-chevron-left"></i> Volver a productos</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'volver_series') { ?>
                    <a href="/lacifo/experimento/cargarSeries/<?php echo $model->id; ?>" class="btn-danger btn m-right5 m-top5 btn-sm"><i class="icon-chevron-left"></i> Volver a series</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'volver_equipos') { ?>
                    <a href="/lacifo/experimento/agregarEquipos/<?php echo $model->id; ?>" class="btn-danger btn m-right5 m-top5 btn-sm"><i class="icon-chevron-left"></i> Volver a equipos</a>
                    <?php } ?>
                    
                    <?php if ($opcion == 'agregar_informacion') { ?>
                    <a href="/lacifo/experimento/informacionAdicional/<?php echo $model->id; ?>" class="btn-primary btn m-right5 m-top5 btn-sm"><i class="icon-info-sign"></i> Agregar información</a>
                    <?php } ?>

                <?php } ?>
            </div>
        </div>
    </section>
</div>

<?php if ($model->estado == 'INICIADO') { ?>
    <?php echo $this->renderPartial('create/_wizard', array('active'=>$mensaje->wizard_active)); ?>
<?php } ?>

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            <span class="">Información del experimento</span>
        </header>
        <div class="panel-body">
            <div class="tab-content">
                <div id="info_basica" class="col-lg-12 no-padding-mobile">
                    <?php echo $data['info_basica']; ?>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </section>
</div>


<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />