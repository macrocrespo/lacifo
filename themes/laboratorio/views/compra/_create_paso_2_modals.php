<!-- FORM EDITAR PRODUCTO -->
<div class="modal fade" id="editar_producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-primary">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Editar producto</h4>
          </div>

          <div id="editar_producto_form" class="modal-body">
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
                    'type'=>'primary',
                    'icon'=>'pencil',
                    'label'=> 'Editar',
                    'url'=>'javascript:editar_producto();'
                )); ?>

          </div>

      </div>
  </div>
</div>

<!-- FORM ELIMINAR PRODUCTO -->
<div class="modal fade" id="eliminar_producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-danger">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Eliminar producto de la compra ?</h4>
          </div>

          <div id="eliminar_producto_form" class="modal-body">
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
                        <td></td>
                    </tr>
                    <tr id="td_cantidadProducto" class="even">
                        <th>Cantidad</th>
                        <td></td>
                    </tr>
              </table>
          </div>
          <div class="modal-footer">

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'label'=>'Cancelar',
                    'icon'=>'ban-circle',
                    'htmlOptions' => array('class'=> 'btn-default', 'data-dismiss'=>'modal')
                )); ?>

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'type'=>'danger',
                    'icon'=>'trash',
                    'label'=> 'Eliminar',
                    'url'=>'javascript:eliminar_producto();'
                )); ?>

          </div>

      </div>
  </div>
</div>

<!-- FORM CARGAR SERIES -->
<div class="modal fade" id="cargar_series" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-success">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Cargar series de productos</h4>
          </div>

          <div id="cargar_series_form" class="modal-body">
              <input type="hidden" id="idProducto" value="0" />
              <table class="detail-view table table-striped table-condensed"></table>

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
                    'icon'=>'tags',
                    'label'=> 'Cargar series',
                    'url'=>'javascript:cargar_series();'
                )); ?>

          </div>

      </div>
  </div>
</div>

<!-- MODAL CONFIRMAR COMPRA -->
<div class="modal fade" id="confirmar_compra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-success">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Confirmar compra</h4>
          </div>

          <div class="modal-body">
            <p>
                  Una vez confirmada la compra, no podrán agregarse más productos.
                  <br />
                  ¿Esta seguro que desea confirmar la compra?
            </p>
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
                    'icon'=>'check-sign',
                    'label'=> 'Confirmar',
                    'url'=> Yii::app()->request->baseUrl.'/'.$this->controller.'/confirmar/'.$model->id
                )); ?>

          </div>

      </div>
  </div>
</div>

<!-- MODAL COMPRA SIN PRODUCTOS -->
<div class="modal fade" id="sin_productos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-warning">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Advertencia</h4>
          </div>

          <div class="modal-body">
            <p>
                  Aún no se han cargado productos en la compra.
            </p>
          </div>


          <div class="modal-footer">

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'label'=>'Aceptar',
                    'icon'=>'double-angle-right',
                    'htmlOptions' => array('class'=> 'btn-warning', 'data-dismiss'=>'modal')
                )); ?>

          </div>

      </div>
  </div>
</div>

<!-- MODAL ANULAR COMPRA -->
<div class="modal fade" id="anular_compra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-danger">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Anular compra</h4>
          </div>

          <div class="modal-body">
            <p>
                  Una vez anulada la compra, la información ingresada se perderá.
                  <br />
                  ¿Esta seguro que desea anular la compra?
            </p>
          </div>

          <div class="modal-footer">

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'label'=>'Cancelar',
                    'icon'=>'ban-circle',
                    'htmlOptions' => array('class'=> 'btn-default', 'data-dismiss'=>'modal')
                )); ?>

                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'type'=>'danger',
                    'icon'=>'remove-sign',
                    'label'=> 'Anular',
                    'url'=> Yii::app()->request->baseUrl.'/'.$this->controller.'/anular/'.$model->id
                )); ?>

          </div>

      </div>
  </div>
</div>