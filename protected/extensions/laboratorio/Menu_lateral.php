<?php
/**
 * Widget personalizado para crear el menú lateral del panel de control
 * Autor: Mario Crespo
 */
class Menu_lateral extends CWidget {
    
    public $items = array();
    public $active = '';
    
    /**
     * Función para generar el menu a partir del array de items
     */
    public function run() {
        $data['items'] = $this->items;
        $data['active'] = $this->active_items();
        $this->render('menu_lateral', $data);
    }
    
    /**
     * Función para generar el array de menu y submenu activos
     * @return type
     */
    private function active_items() {
        $active_menu = '';
        $active_submenu = '';
        if ($this->active != '') {
            $array_active = explode('/', $this->active);
            $active_menu = $array_active[0];
            if (isset($array_active[1]))
                $active_submenu = $array_active[1];
        }
        return array('menu'=>$active_menu, 'submenu'=>$active_submenu);
    }
}
?>