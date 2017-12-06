<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array($this->tipo_contenido=>Yii::app()->request->baseUrl.'/'.$this->controller, 'Detalle del '.$this->contenido), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel', array('title' => 'Detalle del '.$this->contenido, 'size'=>12)); ?>

<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left" style="font-size: 1.2em;">
        <i class="icon-archive"></i>
        <strong><?php echo $model->nombre; ?></strong>
    </h5>
    <div style="clear: both;"></div>
</div>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
                'descripcion',
                array('name'=>'ubicacion', 'value'=> $this->verificarNoDefinido($model->ubicacion)),
                array('name' => 'deposito_id',
                    'type'=>'raw',
                    'value' => CHtml::link(CHtml::encode($model->deposito->nombre),
                                 array('deposito/view','id'=>$model->deposito_id))
                    ),
                array('name'=>'estado', 'value'=> $model->getNombreEstado($model->estado)),
	),
)); ?>

<?php $this->endWidget(); ?>

<div id="panel-productos" class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            Productos<span class="no-phone"> en este contenedor</span>
        </header>
        <div class="panel-body">
            <div id="listado_productos"></div>
        </div>
    </section>
</div>

<?php $this->renderPartial('../site/_view_opciones_generales', array('model'=>$model)); ?>

<input type="hidden" id="id" value="<?php echo $model->id; ?>" />
<input type="hidden" id="tipo" value="contenedor" />
<input type="hidden" id="idView" value="detalles" />
<input type="hidden" id="validar_eliminacion" value="1" />