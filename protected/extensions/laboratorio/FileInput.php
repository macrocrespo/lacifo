<?php
/**
 * Widget personalizado para crear el INPUT FILE para los formularios
 * Autor: Mario Crespo
 */
class FileInput extends CWidget {
    
    public $model_name = '';
    public $campo = '';
    public $label = '';
    
    
    /**
     * Función para generar el menu a partir del array de items
     */
    public function run() {
        if ($this->campo != '') {
            $data['model_name'] = $this->model_name;
            $data['campo'] = $this->campo;
            $data['label'] = $this->label;
            $this->render('file_input', $data);
        }
    }
}
?>