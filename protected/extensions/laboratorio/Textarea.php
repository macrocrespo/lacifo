<?php
/**
 * Widget personalizado para crear el Textarea para los formularios
 * Autor: Mario Crespo
 */
class Textarea extends CWidget {
    
    public $model_name = '';
    public $campo = '';
    public $label = '';
    public $value = '';

    /**
     * Función para generar el menu a partir del array de items
     */
    public function run() {
        if ($this->campo != '') {
            $data['model_name'] = $this->model_name;
            $data['campo'] = $this->campo;
            $data['label'] = $this->label;
            $data['value'] = $this->value;
            $this->render('textarea', $data);
        }
    }
}
?>