<div style="clear: both;"></div>
<?php $this->beginWidget('Panel', array('size'=>12)); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'danger',
        'icon'=>'trash',
        'label'=> 'Eliminar',
        'htmlOptions' => array('class'=>'pull-right m-left10', 'onclick'=>'delete_row('.$model->id.')')
    )); ?>
    
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'warning',
        'icon'=>'pencil',
        'label'=> 'Editar',
        'url'=> Yii::app()->request->baseUrl.'/'.$this->controller.'/update/'.$model->id,
        'htmlOptions'=>array('class'=>'pull-right m-left10')
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'url'=> Yii::app()->request->baseUrl.'/'.$this->controller,
        'icon'=>'list',
        'label'=> 'Ir al listado',
        'htmlOptions'=>array('class'=>'pull-right m-left10', )
    )); ?>

<?php $this->endWidget(); ?>

<!-- Mensaje para confirmar eliminacion -->
<div class="modal fade" id="confirmar_eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header btn-danger">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                  <i class="icon-trash"></i>
                  Confirmar eliminaci&oacute;n
              </h4>
          </div>
          
          <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'delete_row',
            'action'=> Yii::app()->request->baseUrl.'/'.$this->controller.'/delete/'.$model->id)); ?>
          <div class="modal-body">
              ¿ Está seguro que desea eliminar el <?php echo $this->contenido; ?> ?
          </div>
          <div class="modal-footer">
              
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'button',
                    'label'=>'Cancelar',
                    'icon'=>'ban-circle',
                    'htmlOptions' => array('class'=> 'btn-default', 'data-dismiss'=>'modal')
                )); ?>
                
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'danger',
                    'icon'=>'trash',
                    'label'=> 'Eliminar',
                )); ?>
                
          </div>
          
          <?php $this->endWidget(); ?>
          
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
              No se puede eliminar el <?php echo $this->contenido; ?> ya que tiene dependencias asociadas.
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

<input type="hidden" id="controller" value="<?php echo $this->controller; ?>" />