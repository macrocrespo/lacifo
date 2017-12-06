<?php
/**
 * Widget personalizado para crear el menú superior con información del usuario
 * Autor: Mario Crespo
 */
class Usuario_menu_superior extends CWidget {

    public function run() {
        $this->render('usuario_menu_superior');
    }
}
?>