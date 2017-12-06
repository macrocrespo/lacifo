<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active">
                <a data-toggle="tab" href="#01">
                    <i class="icon-home"></i>
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

                <?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>20, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'descripcion',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'inicial',array('class'=>'form-control','maxlength'=>3, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->dropDownListRow($model, 'rubro_id', CHtml::listData(Rubro::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'Seleccionar rubro...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4'))); ?>
                
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

<script type="text/javascript">
$(document).ready(function(){
    $('#tipo_producto-form').submit(function(e){
        var campos = {
            nombre: 'el nombre', 
            descripcion: 'la descripción', 
            inicial: 'la inicial',
            rubro_id: 'el rubro'
        };
        validarForm(e, 'TipoProducto', campos);
    });
});
</script>
    
<?php $this->renderPartial('../site/_form_opciones_generales'); ?>
