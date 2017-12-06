<?php
/**
 * Widget personalizado para crear un mensaje
 * Autor: Mario Crespo
 */
class Mensaje extends CWidget {
    
    public $mensaje         = '';
    public $titulo          = '';
    public $close           = true;
    public $type            = 'info';
    public $show_icon       = true;
    public $icon            = '';
    public $margin          = true;
    
    /**
     * Función para iniciar el panel
     * Se llama con $this->beginWidget('laboratorio.Mensaje');
     */
    public function init() {
        $html = '';
        if ($this->mensaje != '') {

            $html_close = '';
            if ($this->close) {
                $html_close = ' <button type="button" class="close close-sm" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                                </button>';
            }
            
            $html_titulo    = '';
            $html_icon      = '';
            
            if ($this->show_icon || $this->icon != '') {
                if ($this->icon == '') {
                    switch ($this->type) {
                        case 'success': $this->icon = 'ok-sign'; break;
                        case 'danger':  $this->icon = 'remove-sign'; break;
                        case 'info':    $this->icon = 'info-sign'; break;
                        case 'warning': $this->icon = 'warning-sign'; break;
                    }
                }
                $html_icon = '<i class="icon-'.$this->icon.'"></i>';
            }
            
            if ($this->titulo != '') {
                $html_titulo = '<h4>'.$html_icon.$this->titulo.'</h4>';
            }
            else {
                $html_icon .= '&nbsp;&nbsp;';
                $this->mensaje = $html_icon.$this->mensaje;
            }
            
            $this->margin = ($this->margin) ? '' : 'm-bot0';
            
            $html = '
                <div class="alert alert-'.$this->type.' alert-block fade in '.$this->margin.'">
                    '.$html_close.'
                    '.$html_titulo.'
                    <p>'.$this->mensaje.'</p>
                </div>';
        }
        echo $html;
    }
}
?>