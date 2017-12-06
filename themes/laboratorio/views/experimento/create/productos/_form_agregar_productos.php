<?php echo $this->renderPartial('create/_wizard', array('active'=>'productos')); ?>

<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading tab-right">
        <ul class="nav nav-tabs pull-right">
            <li class="active" id="tab1">
                <a data-toggle="tab" href="#01">
                    <i title="Productos agregados" class="icon-beaker"></i>
                    <span class="no-mobile">Productos agregados</span>
                </a>
            </li>
            <li class="" id="tab2">
                <a data-toggle="tab" href="#02">
                    <i title="Buscar productos" class="icon-search"></i>
                    <span class="no-mobile">Buscar productos</span>
                </a>
            </li>
        </ul>
        <span><?php echo $titulo; ?></span>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            <div id="01" class="tab-pane active"> 
                
                <a onclick="$('#tab2 a').click();" class="btn btn-success btn-sm" style="color: #fff;">
                    <i class="icon-search"></i> Buscar productos
                </a>
                
                <?php $this->widget('Mensaje_listado', array(
                    'mensaje'   => 'El producto se ha eliminado correctamente',
                    'class'     => 'mensaje_producto_eliminado no-padding-mobile',
                    'type'      => 'success'
                )); ?>
  
                <div id="productos_por_experimento" class="col-lg-12 no-padding-mobile"></div>
                
            </div>
            <div id="02" class="tab-pane">
                
                <div class="col-lg-12 no-padding-mobile">
                    <form method="POST" class="inline-search form-inline" id="buscar-productos-form">
                        <input type="hidden" id="experimento_id" name="experimento_id" value="<?php echo $model->id; ?>" />
                        <div class="form-group m-top10">
                          <label class="m-right5" for="codigo">Código</label>
                          <input type="text" class="form-control input-sm wsmall" name="codigo">
                        </div>
                        <div class="form-group m-top10">
                          <label class="m-right5" for="nombre">Nombre</label>
                          <input type="text" class="form-control input-sm" name="nombre">
                        </div>
                        <?php if (count($tipo_productos) > 0) { ?>
                        <div class="form-group m-top10">
                          <label class="m-right5" for="tipo">Tipo</label>
                          <select class="form-control input-sm" name="tipo">
                              <option value="0"></option>
                              <?php foreach ($tipo_productos as $tp) { ?>
                              <option value="<?php echo $tp['id']; ?>"><?php echo $tp['nombre']; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                        <?php } ?>
                        <button id="buscar" type="submit" class="btn btn-primary input-sm m-top10">Buscar</button>
                    </form>
                </div>
                
                <?php $this->widget('Mensaje_listado', array(
                    'mensaje'   => 'El producto se ha agregado correctamente',
                    'class'     => 'mensaje_producto_agregado no-padding-mobile',
                    'type'      => 'success'
                )); ?>
                
                <?php $this->widget('Mensaje_listado', array(
                    'mensaje'   => 'Para ver los productos agregados, <a style="cursor: pointer;" onclick="$(\'#tab1 a\').click();">click aquí</a>.',
                    'class'     => 'mensaje_ver_productos_seleccionados no-padding-mobile',
                    'type'      => 'warning'
                )); ?>
                
                <div id="busqueda_productos" class="col-lg-12 no-padding-mobile"></div>

            </div>
        </div>
    </div>
</section>
</div>

<div class="col-lg-12" style="">
    <section class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-block alert-danger fade in m-bot-none" id="error_message" style="display: none;">
                        <div id="message"></div>
                    </div>
                    <div class="hidden-lg hidden-md m-bot20"></div> 
                </div>
                <div class="col-md-4">
                    <div class="form-actions pull-right">
                        <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller; ?>" class="btn-danger btn"><i class="icon-ban-circle"></i> Cancelar</a>
                        <button onclick="javascript:validar_productos();" name="yt0" type="submit" class="btn btn-success"><i class="icon-chevron-sign-right"></i> Continuar</button>        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>