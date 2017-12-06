<?php $experimento = (object) $model; ?>
<div class="alert alert-success alert-block fade in">
    <h5 class="pull-left">
        <i class="icon-ok-sign"></i>
        <strong>Información inicial</strong>
    </h5>
    <a href="<?php echo Yii::app()->request->baseUrl.'/'.$this->controller.'/update/'.$experimento->id; ?>" class="btn btn-success pull-right "><i class="icon-pencil"></i> Editar</a>
    <div style="clear: both;"></div>
</div>
<table id="verificar_info_inicial" class="table table-striped">         
    <tbody>
    <tr>
        <th style="width: 150px;">Título</th>
        <td><?php echo $experimento->titulo; ?></td>
    </tr>
    <tr>
        <th>Descripción</th>
        <td><?php echo $experimento->descripcion; ?></td>
    </tr>
    <tr>
        <th>Condiciones</th>
        <td><?php echo $experimento->condiciones; ?></td>
    </tr>
    <tr>
        <th>Resultados</th>
        <td><?php echo $experimento->resultados; ?></td>
    </tr>
    </tbody>
</table>