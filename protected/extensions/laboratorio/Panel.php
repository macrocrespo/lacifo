<?php
/**
 * Widget personalizado para crear un panel contenedor
 * Autor: Mario Crespo
 */
class Panel extends CWidget {
    
    public $id              = '';
    public $size            = 12;
    public $title           = '';
    public $icon            = '';
    public $min_option      = false;
    public $remove_option   = false;
    public $minimized       = false;
    public $style           = '';
    public $header_class    = '';
    public $class           = '';
    
    /**
     * Función para iniciar el panel
     * Se llama con $this->beginWidget('laboratorio.Panel');
     */
    public function init() {
        if ($this->minimized) {
            $min_icon = 'up';
            $body_display = 'style="display: none;"';
        }
        else {
            $min_icon = 'down';
            $body_display = '';
        }
        
        $min_option_html = '';
        if ($this->min_option || $this->minimized) {
            $min_option_html = '<a class="icon-chevron-'.$min_icon.'" href="javascript:;"></a>';
        }
        
        $remove_option_html = '';
        if ($this->remove_option) {
            $remove_option_html = '<a class="icon-remove" href="javascript:;"></a>';
        }
        
        if ($this->icon != '') {
            $this->icon = '<i class="icon-'.$this->icon.'"></i> ';
        }
        
        if ($this->title != '') {
            $this->title = '
            <header class="panel-heading '.$this->header_class.'">
                '.$this->icon.$this->title.'
                <span class="tools pull-right">
                    '.$min_option_html.'
                    '.$remove_option_html.'
                </span>
            </header>';
        }
        
        $wrapper_id = '';
        $panel_id = '';
        if ($this->id != '') {
            $wrapper_id = 'id="'.$this->id.'_wrapper"';
            $panel_id = 'id="'.$this->id.'"';
        }
        
        $html = '
        <div style="'.$this->style.'" '.$wrapper_id.' class="col-md-'.$this->size.' col-lg-'.$this->size.'">
            <section '.$panel_id.' class="panel '.$this->class.'">
                '.$this->title.'
                <div class="panel-body" '.$body_display.'>';
        echo $html;
    }
    
    /**
     * Función para cerrar el panel
     * Se llama con $this->endWidget();
     */
    public function run() {
        $html = '
                </div>
            </section>
        </div>';
        echo $html;
    }
}
?>