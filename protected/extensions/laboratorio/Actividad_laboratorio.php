<?php
/**
 * Widget personalizado para crear el listado de actividad en el laboratorio
 * Autor: Mario Crespo
 */
class Actividad_laboratorio extends CWidget {
    
    
    /**
     * Función para generar el listado de actividad en el laboratorio
     */
    public function run() {
        $this->render('actividad_laboratorio');
    }
}
?>