<?php

class NotificacionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Notificaciones';
        public $contenido       = 'notificación';
        public $controller      = 'notificacion';
        public $cod_menu        = 'notificacion';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $this->layout='//layouts/listado';

            // Obtener todos los productos con problemas de stock
            $stock = Yii::app()->db->createCommand()
            ->select('p.id, p.nombre, s.minimo, s.sugerido, s.cantidad, s.fecha_consume')
            ->from('stock s')
            ->join('producto p', 'p.id=s.producto_id')
            ->where('s.cantidad < s.sugerido')
            ->order('s.cantidad asc')
            ->queryAll();

            if (count($stock) > 0) {
                // Recorrer el array de productos con problemas de stock
                foreach ($stock as $key => $s) {
                    $s = (object) $s;
                    $s->menor_minimo = false;
                    $s->class = 'warning';
                    $s->recomendacion = 'Se debe aumentar el stock en lo posible.';
                    $s->icon = 'warning-sign';
                    if ($s->cantidad < $s->minimo) {
                        $s->menor_minimo = true;
                        $s->class = 'danger';
                        $s->recomendacion = 'Se debe aumentar el stock urgente.';
                        $s->icon = 'exclamation-sign';
                    }
                    $stock[$key] = $s;
                }
            }
            $data['stock'] = $stock;

            $this->render('admin', $data);
	}
}