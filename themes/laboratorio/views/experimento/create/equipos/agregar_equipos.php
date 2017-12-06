<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array(
            $this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 
            'Crear un nuevo '.$this->contenido
        ), 'separator' => ''
    )); ?>
</div>

<?php echo $this->renderPartial('create/equipos/_form_agregar_equipos', 
        array(
            'model'=>$model, 
            'titulo'=>'Agregar equipos '
        )); ?>

<input type="hidden" id="tipo" value="<?php echo $tipo; ?>" />
<input type="hidden" id="idView" value="agregarEquipos" />
<input type="hidden" id="id" value="<?php echo $model->id; ?>" />
