<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Stock','url'=>array('index')),
	array('label'=>'Create Stock','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stock-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Stocks</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'stock-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'producto_id',
		'minimo',
		'maximo',
		'sugerido',
		'cantidad',
		/*
		'usuario_ingresa_id',
		'fecha_ingresa',
		'usuario_consume_id',
		'fecha_consume',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
