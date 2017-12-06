<body class="lock-login">
<div class="container">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                    'validateOnSubmit'=>true,
            ),
            'htmlOptions' => array(
                'class' => 'form-signin'
            )
    )); ?>
    <h2 class="form-signin-heading"><strong><i class="icon-sun"></i> LACIFO<span class="text-info">WEB</span></strong></h2>
    <div class="login-wrap">
        <?php echo $form->textField($model,'mail', array('class'=>'form-control', 'placeholder'=>'Dirección de mail', 'autofocus'=>'autofocus', 'maxlength'=>50)); ?>
        <?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Contraseña', 'maxlength'=>50)); ?>
        <label class="checkbox">
            <?php echo $form->checkBox($model,'rememberMe'); ?> Recordarme
        </label>
        <?php echo CHtml::submitButton('Ingresar', array('class'=>'btn btn-lg btn-login btn-block')); ?>
    </div>

    <?php 
    $open_div =     '<div class="login-wrap" style="padding-top: 0px; margin-top: -10px;">
                        <div class="alert alert-block alert-danger fade in" style="margin-bottom: 0px;">
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="icon-remove"></i>
                            </button>';
    echo $form->errorSummary($model, $open_div, '</div></div>'); ?>

  <?php $this->endWidget(); ?>

</div>
