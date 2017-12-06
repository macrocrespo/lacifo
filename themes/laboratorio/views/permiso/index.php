<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Configuración', $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->contenido), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel', array('title' => $this->tipo_contenido)); ?>

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>$this->controller.'-form',
            'enableAjaxValidation'=>false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'class'     => 'tasi-form',
                'enctype'   => 'multipart/form-data'
            )
    )); ?>

    <div class="form-group ">
        <label class="col-sm-4 control-label required">Asignar permisos a:</label>
        <div class="col-lg-8">
            <?php echo CHtml::dropDownList(
                    'tipo_a_asignar', 
                    0, 
                    array('Seleccionar...', 1=>'Usuarios', 2=>'Roles'), 
                    array('class' => 'form-control')
                    ); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

<div id="listado"></div>