<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active active_wizard">
                <a data-toggle="tab" href="#01">
                    1) Seleccionar proveedor
                </a>
            </li>
            <li class="inactive_wizard">
                <a data-toggle="tab" href="#02">
                    2) Seleccionar productos
                </a>
            </li>
            <li class="inactive_wizard">
                <a data-toggle="tab" href="#04">
                    3) Confirmar compra
                </a>
            </li>
        </ul>
        <span class="hidden-sm"><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active">
                
                <?php 
                $mensaje = 'Los campos con <strong>*</strong> son requeridos.';
                $this->widget('Mensaje', array('mensaje' => $mensaje, 'icon' => 'chevron-sign-right')); 
                ?>

                <?php echo $form->dropDownListRow($model, 'proveedor_id', CHtml::listData(Proveedor::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Seleccionar proveedor...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'observacion',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->radioButtonListRow($model, 'estado', array(
                    1 => 'Activo',
                    0 => 'Inactivo'),
                    array('labelOptions' => array('class' => 'col-sm-4'))        
                ); ?>

            </div>
        </div>
    </div>
</section>
</div>
    
<?php $this->renderPartial('../site/_form_opciones_generales'); ?>
