<?php if ($total > 0) { ?>

<?php $this->widget('Tabla', array(
    'controller' => 'producto',
    'model' => $productos_por_compra,
    'columnas'=>array(
        array('name'=>'id',             'header'=>'ID'),
        array('name'=>'nombre',         'header'=>'Nombre'),
        array('name'=>'rc_precio',      'header'=>'Costo ($)'),
        array('name'=>'rc_cantidad',    'header'=>'Cantidad'),
        array('name'=>'rc_total',       'header'=>'Subtotal ($)')
        /*
        array('name'=>'',               'header'=>'Usa serie', 
              'html'=>'<input type="checkbox" />'
            ),
         * 
         */
    ),
    'acciones' => array('custom'=>array(
        array(
            'type'=>'success',
            'icon'=>'tags',
            'title'=>'Cargar series',
            'js'=>'form_cargar_series($(this))',
            'modal'=> '#cargar_series'
        ),
        array(
            'type'=>'primary',
            'icon'=>'pencil',
            'title'=>'Editar producto',
            'js'=>'form_editar_producto($(this))',
            'modal'=> '#editar_producto'
        ),
        array(
            'type'=>'danger',
            'icon'=>'trash',
            'title'=>'Eliminar producto de la compra',
            'js'=>'form_eliminar_producto($(this))',
            'modal'=> '#eliminar_producto'
        )
    ))
)); ?>
<?php if ($total > 0) { ?>
<div style="clear: both;"></div>
<h4 style="text-align: right;">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=> $total,
            'icon'=>'dollar',
            'htmlOptions' => array('class'=> 'btn-info btn-sm pull-right')
        )); ?>
    <span style="float: right; margin-top: 4px; margin-right: 8px;">Total de la compra:</span>
</h4>
<?php } ?>
<input type="hidden" id="total" value="<?php echo $total; ?>" />

<?php } ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'success',
    'icon'=>'plus-sign-alt',
    'label'=> 'Agregar producto',
    'url'=>'javascript:ver_agregar_producto();',
    'htmlOptions' => array('class'=> 'btn-sm')
)); ?> 