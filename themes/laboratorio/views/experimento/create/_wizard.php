<?php 
$info_class         = '';
$productos_class    = '';
$series_class       = '';
$equipos_class      = '';
$verificar_class    = '';
switch ($active) {
    case 'info_inicial':    
        $info_class         = 'active'; 
        break;
    case 'productos':
        $info_class         = 'completed'; 
        $productos_class    = 'active';
        break; 
    case 'series':
        $info_class         = 'completed'; 
        $productos_class    = 'completed';
        $series_class       = 'active';
        break; 
    case 'equipos':
        $info_class         = 'completed'; 
        $productos_class    = 'completed';
        $series_class       = 'completed';
        $equipos_class      = 'active';
        break;
    case 'verificar':
        $info_class         = 'completed'; 
        $productos_class    = 'completed';
        $series_class       = 'completed';
        $equipos_class      = 'completed';
        $verificar_class    = 'active';
        break;
}
?>

<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading tab-right">
            <span class="">Etapas en la creación</span>
        </header>
        <div class="panel-body no-padding-mobile" style="padding-bottom: 0px;">
            <ul class="progress-indicator">
                <li class="<?php echo $info_class; ?>" title="Información inicial">
                    <span class="bubble"></span>
                    <i class="icon-home"></i>
                    <t>Información inicial</t>
                </li>
                <li class="<?php echo $productos_class; ?>" title="Agregar productos">
                    <span class="bubble"></span>
                    <i class="icon-beaker"></i>
                    <t>Agregar productos</t>
                </li>
                <li class="<?php echo $series_class; ?>" title="Cargar series">
                    <span class="bubble"></span>
                    <i class="icon-tags"></i>
                    <t>Cargar series</t>
                </li>
                <li class="<?php echo $equipos_class; ?>" title="Agregar equipos">
                    <span class="bubble"></span>
                    <i class="icon-rocket"></i>
                    <t>Agregar equipos</t>
                </li>
                <li class="<?php echo $verificar_class; ?>" title="Verificar información">
                    <span class="bubble"></span>
                    <i class="icon-ok-sign"></i>
                    <t>Verificar información</t>
                </li>
            </ul>
        </div>
    </section>
</div>