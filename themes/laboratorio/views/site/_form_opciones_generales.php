<?php $this->beginWidget('Panel'); ?>

<div class="row">
    <div class="col-md-8">
        <div id="error_message" class="alert alert-block alert-danger fade in m-bot-none">
            <div id="message"></div>
        </div>
        <div class="hidden-lg hidden-md m-bot20"></div> 
    </div>
    <div class="col-md-4">
        <div class="form-actions pull-right">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Cancelar',
                    'icon'=>'ban-circle',
                    'url'=>'javascript:history.back();',
                    'htmlOptions' => array('class'=> 'btn-danger')
                )); ?>
            
                <?php /* $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'reset',
                    'type'=>'info',
                    'icon'=>'eraser',
                    'label'=>'Limpiar'
                    )); */?>
            
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'type'=>'success',
                        'icon'=>'save',
                        'label'=>'Guardar'
                )); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>