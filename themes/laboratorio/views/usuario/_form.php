<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active">
                <a data-toggle="tab" href="#01">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#02">
                    <i class="icon-user"></i>
                    Más información
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

                <?php echo $form->dropDownListRow($model, 'rol_id', CHtml::listData(Rol::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt'=>'seleccionar rol...', 'class' => 'form-control', 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'nombre',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'mail',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->passwordFieldRow($model,'password',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->passwordFieldRow($model,'password_repeat',array('class'=>'form-control','maxlength'=>50, 'labelOptions' => array('class' => 'col-sm-4'))); ?>
            

            </div>
            <div id="02" class="tab-pane">
                
                <?php 
                $this->widget('Mensaje', array('mensaje' => $mensaje, 'icon' => 'chevron-sign-right')); 
                ?>
            
                <?php echo $form->textFieldRow($model,'telefono_trabajo',array('class'=>'form-control','maxlength'=>30, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->textFieldRow($model,'telefono_personal',array('class'=>'form-control','maxlength'=>30, 'labelOptions' => array('class' => 'col-sm-4'))); ?>

                <?php echo $form->radioButtonListRow($model, 'estado', array(
                    1 => 'Activo',
                    0 => 'Inactivo'),
                    array('labelOptions' => array('class' => 'col-sm-4'))        
                ); ?>

                <?php $this->widget('FileInput', array('model_name'=>'Usuario', 'campo'=>'imagen', 'label'=>'Imagen')); ?>

            </div>
        </div>
    </div>
</section>
</div>
    
<?php $this->renderPartial('../site/_form_opciones_generales'); ?>