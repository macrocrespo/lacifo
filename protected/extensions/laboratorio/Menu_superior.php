<?php
/**
 * Widget personalizado para crear el menú superior del panel de control
 * Autor: Mario Crespo
 */
class Menu_superior extends CWidget {
    
    
    /**
     * Función para generar el menu a partir del array de items
     */
    public function run() {
        $stock = Yii::app()->db->createCommand()
        ->select('p.id, p.nombre, s.minimo, s.sugerido, s.cantidad, s.fecha_consume')
        ->from('stock s')
        ->join('producto p', 'p.id=s.producto_id')
        ->where('s.cantidad < s.sugerido')
        ->order('s.cantidad asc')
        ->queryAll();
        
        $data = array();
        $data['cant_notificaciones'] = count($stock);
        $data['class'] = 'warning';
        $data['color'] = 'yellow';

        if (count($stock) > 0) {
            $stock = array_slice($stock, 0, 5);

            // Recorrer el array de productos con problemas de stock
            foreach ($stock as $key => $s) {
                $s = (object) $s;
                $s->menor_minimo = false;
                $s->class = 'warning';
                if ($s->cantidad < $s->minimo) {
                    $s->menor_minimo = true;
                    $s->class = 'danger';
                    $data['class'] = 'danger';
                    $data['color'] = 'red';
                }
                $stock[$key] = $s;
            }
        }
        
        $data['stock'] = $stock;
        $this->render('menu_superior', $data);
    }
}
?>