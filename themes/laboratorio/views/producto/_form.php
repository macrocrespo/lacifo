<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li id="tab1" class="active">
                <a data-toggle="tab" href="#01">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li id="tab2" class="">
                <a data-toggle="tab" href="#02">
                    <i title="Detalle" class="icon-wrench"></i>
                    <span class="no-mobile">Detalle</span>
                </a>
            </li>
            <li id="tab3" class="">
                <a data-toggle="tab" href="#03">
                    <i title="Stock" class="icon-shopping-cart"></i>
                    <span class="no-mobile">Stock</span>
                </a>
            </li>
            <li id="tab4" class="">
                <a data-toggle="tab" href="#04">
                    <i title="Más información" class="icon-info-sign"></i>
                    <span class="no-mobile">Más información</span>
                </a>
            </li>
        </ul>
        <span><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active">
                
                <?php 
                $mensaje = 'Los campos con <strong>*</strong> son requeridos.';
                $this->widget('Mensaje', array('mensaje' => $mensaje, 'icon' => 'chevron-sign-right')); 
                ?>

                <?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'nombre_ingles',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'descripcion',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'marca',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>
                
                <?php echo $form->radioButtonListRow($model, 'estado', array(
                    1 => 'Activo',
                    0 => 'Inactivo'),
                    array('labelOptions' => array('class' => 'col-sm-4'))        
                ); ?>
                
            </div>
            <div id="02" class="tab-pane">
                
                <?php 
                $this->widget('Mensaje', array('mensaje' => $mensaje, 'icon' => 'chevron-sign-right')); 
                ?>
                
                <?php echo $form->dropDownListRow($model, 'rubro', CHtml::listData(Rubro::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Seleccionar rubro...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->dropDownListRow($model, 'tipo_producto_id', $tipo_producto_data, array('prompt'=>'Seleccione un rubro primero...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4') )); ?>

                <?php echo $form->dropDownListRow($model, 'deposito', CHtml::listData(Deposito::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Seleccionar depósito...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->dropDownListRow($model, 'contenedor_id', $contenedor_data, array('prompt'=>'Seleccione un depósito primero...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'IUPAC',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'CAS',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

            </div>
            <div id="03" class="tab-pane">
                
                <?php 
                $this->widget('Mensaje', array('mensaje' => $mensaje, 'icon' => 'chevron-sign-right')); 
                ?>
                
                <?php echo $form->textFieldRow($stock,'minimo',array('class'=>'form-control','maxlength'=>10, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($stock,'maximo',array('class'=>'form-control','maxlength'=>10, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($stock,'sugerido',array('class'=>'form-control','maxlength'=>10, 'labelOptions' => array('class' => 'col-sm-4'))); ?>
                
                <?php echo $form->textFieldRow($stock,'cantidad',array('class'=>'form-control','maxlength'=>10, 'labelOptions' => array('class' => 'col-sm-4'))); ?>
                
            </div>
            <div id="04" class="tab-pane">
                <div id="detalle">
                    <div class="form-group">
                        <label for="inputSuccess" class="col-sm-4 control-label">Opciones</label>
                        <div class="col-lg-8">
                            <div class="checkbox">
                                <label for="Producto_usa_serie">
                                    <input type="hidden" name="Producto[usa_serie]" value="0" id="ytProducto_usa_serie">
                                    <input <?php if ($model->usa_serie) echo 'checked="checked"'; else echo ''; ?> type="checkbox" value="1" id="Producto_usa_serie" name="Producto[usa_serie]">
                                    Usa serie?
                                </label>
                            </div>

                            <?php // $this->widget('Checkbox', array('model'=>$model, 'id'=>'usa_detalle', 'label'=>'Utiliza detalle.')); ?>

                            <div class="checkbox">
                                <label for="Producto_usa_detalle">
                                    <input type="hidden" name="Producto[usa_detalle]" value="0" id="ytProducto_usa_detalle">
                                    <input onclick="habilitar_detalle();" <?php if ($model->usa_detalle) echo 'checked="checked"'; else echo ''; ?> type="checkbox" name="Producto[usa_detalle]" id="Producto_usa_detalle" value="1">
                                    Desea agregar más información?
                                </label>
                            </div>
                        </div>
                    </div>

                    <?php echo $form->textFieldRow($producto_detalle,'fraccion',array('disabled'=>'disabled', 'class'=>'form-control','maxlength'=>4, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                    <?php echo $form->textFieldRow($producto_detalle,'unidad_medida',array('disabled'=>'disabled', 'class'=>'form-control','maxlength'=>4, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                    <?php echo $form->textFieldRow($producto_detalle,'formula_quimica',array('disabled'=>'disabled', 'class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                    <?php echo $form->textFieldRow($producto_detalle,'peso_molecular',array('disabled'=>'disabled', 'class'=>'form-control','maxlength'=>20, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                    <?php echo $form->textFieldRow($producto_detalle,'laboratorio',array('disabled'=>'disabled', 'class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
    
<?php $this->renderPartial('../site/_form_opciones_generales'); ?>
