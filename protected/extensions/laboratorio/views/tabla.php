<?php if (!empty($model)) { ?>
<div class="adv-table">
    <table  class="display table table-bordered table-striped listado tabla_<?php echo $random; ?>">
      <thead>
      <tr>
            <?php 
            // Títulos de las columnas de la tabla
            foreach ($columnas as $columna):
                $th_class = '';
                if (isset($columna['class'])) {
                    $th_class = 'class="'.$columna['class'].'"';
                }
                echo '<th '.$th_class.'>'.CHtml::encode ($columna['header']).'</th>';
            endforeach; 
          
          // Acciones
          if (!empty($acciones)):
              echo '<th class="center" style="width: 90px;">Acciones</th>';
          endif;
          ?>
      </tr>
      </thead>
      <tbody>
          <?php
          // Contenido de la tabla
          foreach ($model as $r) { // INICIO COLUMNAS ?>
                <tr id="<?php echo $r->id; ?>">
                <?php foreach ($columnas as $columna):
                    $td_class = '';
                    if (isset($columna['class'])) {
                        $td_class = 'class="'.$columna['class'].'"';
                    }
                    if (isset($columna['relation'])) {
                        $relation = explode('->', $columna['relation']);
                        echo '<td '.$td_class.'>'.CHtml::encode ($r->$relation[0]->$relation[1]).'</td>';
                    }
                    else {
                        echo '<td '.$td_class.'>';
                        if (isset($r->$columna['name'])) {
                            echo CHtml::encode ($r->$columna['name']);
                        }
                        if (isset($columna['html']) && $columna['html'] != '') {
                            echo $columna['html'];
                        }
                        echo '</td>';
                    }
                endforeach; 
                if (!empty($acciones)) { // ACCIONES ?>
                    <?php $url_controller = Yii::app()->request->baseUrl.'/'.$this->controller; ?>
                    <td>
                        <div class="btn-group">
                        <?php if (isset($acciones['ver']) && $acciones['ver']) { ?>
                            <a title="Detalles" class="btn btn-xs btn-primary" href="<?php echo $url_controller.'/view/'.$r->id; ?>">
                                <i class="icon-info-sign"></i>
                            </a>
                        <?php } ?>
                        <?php if (isset($acciones['editar']) && $acciones['editar']) { ?>
                            <a title="Editar" class="btn btn-xs btn-warning" href="<?php echo $url_controller.'/update/'.$r->id; ?>">
                                <i class="icon-edit"></i>
                            </a>
                        <?php } ?>
                        <?php if (isset($acciones['eliminar']) && $acciones['eliminar']) { ?>
                            <a class="btn-xs btn btn-danger" title="Eliminar" onclick="delete_row(<?php echo $r->id; ?>)">
                                <i class="icon-trash"></i>
                            </a>
                        <?php } ?>
                        </div>

                        <?php
                        // Opcion personalizada
                        if (isset($acciones['custom'])):
                            if (isset($acciones['custom'][0])) {
                                foreach ($acciones['custom'] as $custom) {
                                    $url = (isset($custom['action'])) ? Yii::app()->request->baseUrl.'/'.$custom['action'].'/'.$r->id : '';
                                    $type = (isset($custom['type'])) ? $custom['type'] : '';
                                    $icon = (isset($custom['icon'])) ? $custom['icon'] : '';
                                    $label = (isset($custom['label'])) ? $custom['label'] : '';
                                    $title = (isset($custom['title'])) ? $custom['title'] : '';
                                    $onClick = (isset($custom['js'])) ? $this->remplazar_params($custom['js'], $r) : '';
                                    $htmlOptions = array('class'=>'btn-xs m-right5', 'title'=>$title, 'onClick'=>$onClick);
                                    if (isset($custom['modal'])) {
                                        $url = $custom['modal'];
                                        $htmlOptions['data-toggle'] = 'modal';
                                    }
                                    $this->widget('bootstrap.widgets.TbButton', array(
                                        'type'=> $type,
                                        'icon'=> $icon,
                                        'label'=> $label,
                                        'url'=> $url,
                                        'htmlOptions'=> $htmlOptions
                                    ));
                                }
                            }
                            else {
                                $url = (isset($acciones['custom']['action'])) ? Yii::app()->request->baseUrl.'/'.$acciones['custom']['action'].'/'.$r->id : '';
                                $type = (isset($acciones['custom']['type'])) ? $acciones['custom']['type'] : '';
                                $icon = (isset($acciones['custom']['icon'])) ? $acciones['custom']['icon'] : '';
                                $label = (isset($acciones['custom']['label'])) ? $acciones['custom']['label'] : '';
                                $title = (isset($acciones['custom']['title'])) ? $acciones['custom']['title'] : '';
                                $onClick = (isset($acciones['custom']['js'])) ? $this->remplazar_params($acciones['custom']['js'], $r) : '';
                                $htmlOptions = array('class'=>'btn-xs m-right5', 'title'=>$title, 'onClick'=>$onClick);
                                if (isset($acciones['custom']['modal'])) {
                                    $url = $acciones['custom']['modal'];
                                    $htmlOptions['data-toggle'] = 'modal';
                                }
                                $this->widget('bootstrap.widgets.TbButton', array(
                                    'type'=> $type,
                                    'icon'=> $icon,
                                    'label'=> $label,
                                    'url'=> $url,
                                    'htmlOptions'=> $htmlOptions
                                ));
                            }
                        endif; ?>
                    </td>
                <?php } // FIN ACCIONES ?>
                </tr>
          <?php } // FIN COLUMNAS ?>
      </tbody>
    </table>
    <?php if ($no_sort != '') { ?>
    <input type="hidden" id="no_sort_columns" value="<?php echo $no_sort; ?>" />
    <?php } ?>
</div>
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
            'id'=>'delete_row')); ?>
          <div class="modal-body">
              ¿ Esta seguro que desea eliminar <?php echo $txt_eliminar; ?> ?
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
                    'htmlOptions' => array('onclick'=> 'validarEliminacion()')
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
              No se puede eliminar <?php echo $txt_eliminar; ?> ya que tiene dependencias asociadas.
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

<input type="hidden" id="controller" value="<?php echo $contenido; ?>" />
<input type="hidden" id="validar_eliminacion" value="<?php echo $validar_eliminacion; ?>" />
<?php if ($add_script) { ?>
<script type="text/javascript">
$(document).ready(function() {
    $('.tabla_<?php echo $random; ?>').dataTable({
        /* "bFilter": false // Quitar el filtro */
        "bAutoWidth": false,
        <?php if ($no_sort != '') { ?>
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [ <?php echo $no_sort; ?> ] }]
        <?php } ?>
    });
});
</script>
<?php } 
} else { ?>
<div class="alert alert-info fade in">
  <?php echo $no_results; ?>
</div>
<?php } ?>

