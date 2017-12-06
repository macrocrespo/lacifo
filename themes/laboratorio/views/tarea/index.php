<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller
        ), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel'); ?>

    <?php echo $this->renderPartial('_forms', 
        array(
            'data'=>$data
        )); ?>

<?php $this->endWidget(); ?>

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            <span class="hidden-sm">Listado de tareas</span>
        </header>
        <div class="panel-body">
            <div id="listado_tareas"></div>
        </div>
    </section>
</div>

<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="tareas" />