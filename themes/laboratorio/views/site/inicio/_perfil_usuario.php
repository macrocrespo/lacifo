<aside class="profile-nav alt green-border">
    <section class="panel">
        <div class="twt-feed blue-bg">
            <h1><?php echo Yii::app()->user->nombre; ?></h1>
            <p><?php echo Yii::app()->user->mail; ?></p>
            <a <?php /* href="<?php echo Yii::app()->request->baseUrl.'/'; ?>usuario/perfil" */ ?>>
                <img alt="<?php echo Yii::app()->user->nombre; ?>" src="<?php echo Yii::app()->request->baseUrl.'/'; ?>images/usuarios/<?php echo Yii::app()->user->imagen; ?>">
            </a>
        </div>
        
        <div class="twt-category">
            <div id="lista_perfil_usuario" style="display: none;"></div>
        </div>
    </section>
</aside>