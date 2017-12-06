<?php echo $this->renderPartial('create/_wizard', array('active'=>'series')); ?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i class="icon-tags"></i>
                </a>
            </li>
        </ul>
        <span class=""><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                    <?php 
                    $sin_productos = 0;
                    $productos_sin_series = 0;
                    if (count($data['productos']) > 0) {
                    
                        if ($data['cargar_series']) {
                            
                            foreach ($data['productos'] as $p) {
                                if ($p->producto_usa_serie) { ?>

                                <div class="form-group serie-por-producto">
                                    <label style="margin-bottom: 20px;" class="label-series control-label col-md-4">
                                        <i class="icon-beaker"></i>
                                        <?php echo $p->nombre; ?>
                                        
                                        <?php $p->cantidad = $p->cantidad - $p->cantidad_asignada; ?>
                                        <?php $this->widget('Mensaje_listado', array(
                                            'mensaje'   => 'Se deben seleccionar '.$p->cantidad.' series.',
                                            'class'     => 'txt_estado_series seleccionar_series_'.$p->id,
                                            'type'      => 'warning',
                                            'show'      => true
                                        )); ?>
                                        
                                        <?php $this->widget('Mensaje_listado', array(
                                            'mensaje'   => '<i class="icon-check"></i> Se han seleccionado todas las series.',
                                            'class'     => 'txt_estado_series series_seleccionadas_'.$p->id,
                                            'type'      => 'success'
                                        )); ?>
                                        <input type="hidden" class="series_status" id="series_to_select_<?php echo $p->id; ?>" value="<?php echo $p->cantidad; ?>" />
                                    </label>
                                    <div class="col-md-8">
                                        <select multiple="multiple" class="multi-select" id="producto_<?php echo $p->id; ?>" name="series[<?php echo $p->id; ?>][]">
                                            <?php // Recorrer array de series con vencimientos
                                            foreach ($p->series as $vencimiento => $series) {
                                                // Por cada vencimiento, cargar las series en el select 
                                                $date = new DateTime($vencimiento);
                                                $date = $date->format('d/m/Y'); ?>
                                                <optgroup label="Vence: <?php echo $date; ?>">
                                                <?php foreach ($series as $s) {
                                                    $selected = (isset($s->selected) && $s->selected) ? 'selected' : '';
                                                    ?>
                                                    <option <?php echo $selected; ?>><?php echo $s->serie; ?></option>
                                                <?php } ?>
                                                </optgroup>    
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>    
      
                                <?php }
                            }
                            
                        } else {
                            $this->widget('Mensaje_listado', array(
                                'mensaje'   => 'No hay series para cargar en los productos seleccionados. Puede continuar con la siguiente etapa.',
                                'class'     => 'mensaje_productos_sin_series',
                                'type'      => 'warning',
                                'show'      => true
                            ));
                            $productos_sin_series = 1;
                        }
                    
                    } else { 
                        $url = Yii::app()->request->baseUrl.'/'.$this->controller.'/agregarProductos/'.$model->id;
                        $this->widget('Mensaje_listado', array(
                            'mensaje'   => 'Para cargar series, se deben agregar productos al experimento. Para agregar productos, <a style="cursor: pointer;" href="'.$url.'">click aquí</a>.',
                            'class'     => 'mensaje_sin_productos',
                            'type'      => 'warning',
                            'show'      => true
                        ));
                        $sin_productos = 1;
                    } ?>
                
            </div>
        </div>
    </div>
</section>
</div>

<div class="col-lg-12" style="">
    <section class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-block alert-danger fade in m-bot-none" id="error_message" style="display: none;">
                        <div id="message"></div>
                    </div>
                    <div class="hidden-lg hidden-md m-bot20"></div> 
                </div>
                <div class="col-md-4">
                    <div class="form-actions pull-right">
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-danger btn"><i class="icon-ban-circle"></i> Cancelar</a>
                        <a onclick="javascript:validar_series();" class="btn btn-success"><i class="icon-chevron-sign-right"></i> Continuar</a>       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<input type="hidden" id="sin_productos" value="<?php echo $sin_productos; ?>" />
<input type="hidden" id="productos_sin_series" value="<?php echo $productos_sin_series; ?>" />
<input type="hidden" name="experimento_id" value="<?php echo $model->id; ?>" />