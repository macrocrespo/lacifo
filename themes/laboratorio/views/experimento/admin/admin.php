<?php $url_controller = Yii::app()->request->baseUrl.'/'.$this->controller; ?>
<div class="col-lg-12">
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>array('Gestión de experimentos'=>$url_controller), 'separator' => ''
    )); ?>
</div>

<?php $this->beginWidget('Panel'); ?>
    <a href="<?php echo $url_controller.'/create'; ?>" class="btn btn-success btn-sm" style="color: #fff;">
        <i class="icon-plus-sign-alt"></i> Crear experimento
    </a>
<?php $this->endWidget(); ?>

<div id="resumen_experimentos"></div>

<div id="listado_experimentos_wrapper" class="col-lg-12" style="">
    <section class="panel">
        <header class="panel-heading" style="height: 52px;">
            <span class="no-phone">Listado de </span>Experimentos
            <div class="pull-right">
                <a id="btn_show_advanced_search" onclick="show_advanced_search();" class="btn btn-primary btn-sm" style="color: #fff;">
                    <i class="icon-bolt m-right5"></i> Búsqueda<span class="no-phone"> avanzada</span>
                </a>
            </div>
            <div style="clear: both;"></div>
        </header>
        <div class="panel-body">
            
            <div id="advanced_search">
                <a title="Cerrar" onclick="hide_advanced_search();" id="close_advanced_search" class="close" aria-hidden="true">×</a>
                <form method="POST" class="inline-search form-inline" id="advanced_search_form">
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="titulo"><i class="icon-home"></i> Título</label>
                          <input type="text" class="form-control input-sm" id="titulo" name="titulo">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="estado"><i class="icon-map-marker"></i> Estado</label>
                          <select class="form-control input-sm" id="estado" name="estado">
                              <option value=""></option>
                              <option value="INICIADO">Iniciado</option>
                              <option value="PREPARADO">Preparado</option>
                              <option value="EN_CURSO">En curso</option>
                              <option value="FINALIZADO">Finalizado</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="creacion_desde"><i class="icon-time"></i> Creado desde</label>
                          <div class="input-group">
                            <input type="text" class="form-control input-sm datepicker" readonly="readonly" id="creacion_desde" name="creacion_desde">
                            <div class="input-group-btn">
                                <button onclick="borrar_datepicker('creacion_desde');" title="Borrar" type="button" class="btn btn-default" style="margin-top: 1px;">
                                    <i class="icon-remove-sign"></i>
                                </button>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="creacion_hasta"><i class="icon-time"></i> Creado hasta</label>
                          
                          <div class="input-group">
                            <input type="text" class="form-control input-sm datepicker" readonly="readonly" id="creacion_hasta" name="creacion_hasta">
                            <div class="input-group-btn">
                                <button onclick="borrar_datepicker('creacion_hasta');" title="Borrar" type="button" class="btn btn-default" style="margin-top: 1px;">
                                    <i class="icon-remove-sign"></i>
                                </button>
                            </div>
                          </div>

                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="usuario"><i class="icon-user"></i> Usuario</label>
                          <select class="form-control input-sm" id="usuario" name="usuario">
                              <option value=""></option>
                              <?php foreach ($data['usuarios'] as $u) { $u = (object) $u; ?>
                              <option value="<?php echo $u->id; ?>"><?php echo $u->nombre; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="productos"><i class="icon-beaker"></i> Productos</label>
                          <div class="input-group">
                            <input type="text" class="form-control input-sm" id="productos" name="productos">
                            <div class="input-group-btn">
                                <button title="Puede buscar por nombre, descripción, nombre en ingles o IUPAC" type="button" class="btn btn-default">
                                    <i class="icon-question-sign"></i>
                                </button>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <label for="equipos"><i class="icon-rocket"></i> Equipos</label>
                          <div class="input-group">
                            <input type="text" class="form-control input-sm" id="equipos" name="equipos">
                            <div class="input-group-btn">
                                <button title="Puede buscar por nombre, marca, modelo u observaciones" type="button" class="btn btn-default">
                                    <i class="icon-question-sign"></i>
                                </button>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button id="buscar" type="submit" class="btn btn-primary input-sm">
                            <i class="icon-search m-right5"></i>Buscar
                        </button>
                    </div>
                    <div style="clear: both;"></div>
                </form>
            </div>

            <div id="listado_experimentos"></div>
            
        </div>
    </section>
</div>

<input type="hidden" id="experimento_seleccionado" value="" />
<div class="modal fade" id="confirmar_eliminar_experimento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header label-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                ¿ Esta seguro que desea eliminar el experimento ?
                <br ><br />
                Al eliminar el experimento, se eliminará toda la información asociada, incluyendo productos, series, equipos e información adicional.
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                <button data-dismiss="modal" class="btn btn-danger" onclick="eliminar_experimento();" type="button">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="idView" value="admin" />