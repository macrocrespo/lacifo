<?php
/**
 * Widget personalizado para crear una tabla con contenido dinámico
 * Autor: Mario Crespo
 */
class Tabla extends CWidget {

    public $model = null;
    public $controller = '';
    public $contenido = '';
    public $no_results = 'No se han encontrado resultados.';
    public $columnas = array();
    public $no_sort = '';
    public $txt_eliminar = '';
    public $acciones = array();
    public $validar_eliminacion = false;
    
    public function run() {
        if ($this->controller != '' && !empty($this->columnas)) {
            $data['model'] = $this->model;
            $data['controller'] = $this->controller;
            $data['columnas'] = $this->columnas;
            $data['no_sort'] = $this->no_sort;
            $data['no_results'] = $this->no_results;
            $data['acciones'] = $this->acciones;
            $data['validar_eliminacion'] = ($this->validar_eliminacion) ? 1 : 0;
            $data['contenido'] = ($this->contenido != '') ? $this->contenido : $this->controller; 
            $data['txt_eliminar'] = ($this->txt_eliminar != '') ? $this->txt_eliminar : 'el '.$data['contenido'];
            $data['add_script'] = false;
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
                $data['add_script'] = true;
            $data['random'] = rand(1, 100);
            $this->render('tabla', $data);
        }
    }
    
    /**
     * Función para reemplazar los parámetros por valores de la DB
     * @param type $string
     * @param type $r
     * @return type
     */
    public function remplazar_params($string = '', $r = null) {
        $patron = '/[\[\]]+/';
        $params = preg_split($patron, $string);
        foreach ($params as $key => $param) {
            if ($key % 2 > 0) {
                $string = str_replace('['.$param.']', $r->$param, $string);
            }
        }
        return $string;
    }
}
?>