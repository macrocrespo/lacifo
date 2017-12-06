<?php $url_controller = Yii::app()->request->baseUrl.'/'.$this->controller; ?>
<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Productos'=>$url_controller), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel'); ?>
    <a href="<?php echo $url_controller.'/create'; ?>" class="btn btn-success btn-sm" style="color: #fff;">
        <i class="icon-plus-sign-alt"></i> Crear producto
    </a>
<?php $this->endWidget(); ?>

<div id="listado_productos_wrapper" class="col-lg-12" style="">
    <section class="panel">
        <header class="panel-heading" style="height: 52px;">
            Listado de productos
        </header>
        <div class="panel-body">
            <div id="listado_productos"></div>
        </div>
    </section>
</div>

<div class="modal fade" id="confirmar_eliminar_producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="icon-trash"></i>
                    Confirmar eliminación
                </h4>
            </div>
            <div class="modal-body">
                ¿ Esta seguro que desea eliminar el producto ?
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-danger" onclick="eliminar_producto();" type="button">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Mensaje para avisar que no se puede eliminar -->
<div class="modal fade" id="mensaje_no_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-warning">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                  <i class="icon-warning-sign"></i>
                  Advertencia
              </h4>
          </div>
          
          <div class="modal-body">
              No se puede eliminar el producto ya que tiene dependencias asociadas.
          </div>
          <div class="modal-footer">
              
              <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'label'=>'Aceptar',
                    'htmlOptions' => array('class'=> 'btn-default', 'data-dismiss'=>'modal')
                )); ?>
          </div>
      </div>
  </div>
</div>
<input type="hidden" id="producto_seleccionado" value="" />
<input type="hidden" id="idView" value="admin" />