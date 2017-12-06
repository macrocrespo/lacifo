<?php
/**
 * Widget personalizado para crear el INPUT FILE para los formularios
 * Autor: Mario Crespo
 */
class Textbox extends CWidget {
    
    public $campo = '';
    public $label = '';

    /**
     * Función para generar el menu a partir del array de items
     */
    public function run() {
        if ($this->campo != '') {
            $data['campo'] = $this->campo;
            $data['label'] = $this->label;
            $this->render('textbox', $data);
        }
    }
}
?>