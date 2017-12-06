<!--header start-->
<header class="header blue-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Menú" data-placement="right" class="icon-reorder tooltips"></div>
    </div>

    <a href="<?php echo Yii::app()->request->baseUrl; ?>" class="logo"><strong><i class="icon-sun"></i> LACIFO<span class="text-info">WEB</span></strong></a>

    <?php $this->widget('Menu_superior'); ?>
    
    <div class="top-nav ">
        <?php $this->widget('Usuario_menu_superior'); ?>
    </div>
</header>
<!--header end-->
