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

                <?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'descripcion',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'direccion',array('class'=>'form-control','maxlength'=>100, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'telefono',array('class'=>'form-control','maxlength'=>30, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

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
    $('#deposito-form').submit(function(e){
        var campos = {
            nombre: 'el nombre', 
            descripcion: 'la descripción'
        };
        validarForm(e, 'Deposito', campos);
    });
});
</script>
    
<?php $this->renderPartial('../site/_form_opciones_generales'); ?>    