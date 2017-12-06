<input type="hidden" id="ppc" value="<?php echo $productos_por_compra; ?>" />
<br /><br /><br />
<?php $this->widget('Tabla', array(
    'controller' => 'producto',
    'model' => $productos_por_nombre,
    'columnas'=>array(
        array('name'=>'id',             'header'=>'ID'),
        array('name'=>'nombre',         'header'=>'Nombre'),
        array('name'=>'tipo_producto_id',    'header'=>'Tipo de producto', 'relation' => 'tipo_producto->nombre'),
        ),
    'acciones' => array('custom'=>array(
        'type'=>'success',
        'icon'=>'plus-sign-alt',
        'title'=>'Agregar producto',
        'js'=>'form_agregar_producto($(this))',
        'modal'=> '#agregar_producto',
    ))
)); ?>

<!-- FORM AGREGAR PRODUCTO -->
<div class="modal fade" id="agregar_producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-success">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Agregar producto</h4>
          </div>

          <div id="agregar_producto_form" class="modal-body">
              <input type="hidden" id="idProducto" value="0" />
              <table class="detail-view table table-striped table-condensed">
                    <tr id="td_idProducto" class="odd">
                        <th>ID</th>
                        <td></td>
                    </tr>
                    <tr id="td_nombreProducto" class="even">
                        <th>Nombre</th>
                        <td></td>
                    </tr>
                    <tr id="td_costoProducto" class="odd">
                        <th>Costo unitario ($)</th>
                        <td><input value="" type="text" class="form-control" /></td>
                    </tr>
                    <tr id="td_cantidadProducto" class="even">
                        <th>Cantidad</th>
                        <td><input value="1" type="text" class="form-control" /></td>
                    </tr>
              </table>
              
                <div id="errors" class="alert alert-danger alert-block fade in" style="display: none; margin-bottom: -20px;">
                    <p></p>
                </div>
          </div>
          <div class="modal-footer">
              
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'label'=>'Cancelar',
                    'icon'=>'ban-circle',
                    'htmlOptions' => array('class'=> 'btn-default', 'data-dismiss'=>'modal')
                )); ?>
                
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'type'=>'success',
                    'icon'=>'plus-sign-alt',
                    'label'=> 'Agregar',
                    'url'=>'javascript:agregar_producto();'
                )); ?>
                
          </div>
          
      </div>
  </div>
</div>