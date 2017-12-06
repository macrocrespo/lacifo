<?php
/**
 * Widget personalizado para crear el perfil del usuario en la página de inicio
 * Autor: Mario Crespo
 */
class Perfil_usuario extends CWidget {
    
    /**
     * Función para mostrar la vista de perfil del usuario
     */
    public function run() {
        $this->render('perfil_usuario');
    }
}
?>