<?php
/**
 * Widget personalizado para crear un mensaje de alerta en los listados
 * Autor: Mario Crespo
 */
class Mensaje_listado extends CWidget {
    
    public $mensaje = '';
    public $class   = '';
    public $type    = '';
    public $show    = false;
    
    /**
     * Función para iniciar el widget
     * Se llama con $this->beginWidget('laboratorio.Mensaje_listado');
     */
    public function init() {
        $html = '';
        if ($this->mensaje != '') {   
            $display = ($this->show) ? '' : 'display: none;';
            $html = '
                <div style="clear: both;"></div>
                <!-- <div class="col-lg-2 '.$this->class.' m-top20" style="'.$display.'"></div> -->
                <div class="col-lg-12 '.$this->class.' m-top20" style="'.$display.'">
                    <div class="alert alert-'.$this->type.' fade in text-center m-bot0">
                        '.$this->mensaje.'
                    </div>
                </div>
                <!-- <div class="col-lg-2 '.$this->class.' m-top20" style="'.$display.'"></div> -->
                <div style="clear: both;"></div>';
        }
        echo $html;
    }
}
?>