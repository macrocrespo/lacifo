<?php $url_controller = Yii::app()->request->baseUrl.'/'.$this->controller; ?>
<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Notificaciones'=>$url_controller), 'separator' => ''
    )); ?>
</div>

<div class="col-lg-12" style="">
    <section class="panel">
        <header class="panel-heading" style="height: 52px;">
            Listado de notificaciones
        </header>
        <div class="panel-body">
            
            <?php if (count($stock) > 0) { ?>

            <div id="listado_notificaciones">
                
                <div class="adv-table">
                    <table class="display table table-bordered table-striped listado">
                        <thead>
                            <tr>
                                <th class="center">Estado</th>
                                <th class="hidden-xs">Código</th>
                                <th>Nombre</th>
                                <th class="center">Cantidad</th>
                                <th class="center hidden-xs">Mínimo</th>
                                <th class="center hidden-xs">Sugerido</th>
                                <th title="Fecha de último consumo" class="hidden-xs">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stock as $s) { ?>
                            <tr>
                                <td class="center">
                                    <span class="hidden"><?php echo $s->class; ?></span>
                                    <i title="<?php echo $s->recomendacion; ?>" class="fsize125 title_in_modal text-<?php echo $s->class; ?> icon-<?php echo $s->icon; ?>"></i>
                                </td>
                                <td class="hidden-xs"><?php echo $s->id; ?></td>
                                <td>
                                    <?php echo $s->nombre; ?>
                                    <div style="display: inline-block; float: right;">
                                        <i title="Fecha de último consumo: <?php echo $this->fecha_formato_listado($s->fecha_consume); ?>" class="only-mobile text-success icon-time fsize125 title_in_modal pull-right"></i>
                                        <i title="Cantidad sugerida: <?php echo $s->sugerido; ?>" class="only-mobile text-warning icon-beaker fsize125 title_in_modal pull-right"></i>
                                        <i title="Cantidad mínima: <?php echo $s->minimo; ?>" class="only-mobile text-danger icon-beaker fsize125 title_in_modal pull-right"></i>
                                    </div>
                                </td>
                                <td class="center"><?php echo $s->cantidad; ?></td>
                                <td class="center hidden-xs"><?php echo $s->minimo; ?></td>
                                <td class="center hidden-xs"><?php echo $s->sugerido; ?></td>
                                <td class="hidden-xs">
                                    <span class="hidden"><?php echo $s->fecha_consume; ?></span>
                                    <?php echo $this->fecha_formato_listado($s->fecha_consume); ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            
            <?php } else {
                
            print_r(var_dump($stock));
            
            $this->widget('Mensaje', array(
                'mensaje'   => 'No hay notificaciones para mostrar en el sistema.',
                'type'      => 'warning',
                'show_icon' => true,
                'close'     => false
            ));
            
            } ?>
            
        </div>
    </section>
</div>
<input type="hidden" id="idView" value="admin" />