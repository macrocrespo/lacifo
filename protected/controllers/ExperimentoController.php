<?php
/**
 * Experimento (controller)
 * Controlador para realizar todas las funciones asociadas a un experimento
 */

class ExperimentoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Experimentos';
        public $contenido       = 'experimento';
        public $controller      = 'experimento';
        public $cod_menu        = 'experimento';

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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            try {
                $this->layout='//layouts/listado';
                $tipo = 'Experimento';
                $model = $this->loadModel($id);
                $this->add_js('js/laboratorio/experimento.js');

                $info_basica = $this->_info_basica_experimento($id);

                // Productos
                $productos = Yii::app()->db->createCommand()
                ->select('p.id, p.nombre, tp.nombre as tipo, ep.producto_usa_serie, ep.cantidad, pd.fraccion, pd.unidad_medida')
                ->from('producto p')
                ->join('experimento_producto ep', 'ep.producto_id=p.id')
                ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
                ->leftJoin('producto_detalle pd', 'pd.producto_id=p.id')
                ->where('ep.experimento_id=:id', array(':id'=>$id))
                ->queryAll();

                // Series
                $series = Yii::app()->db->createCommand()
                ->select('es.serie, s.vencimiento, p.id, p.nombre')
                ->from('experimento_serie es')
                ->join('serie s', 's.serie=es.serie')     
                ->join('experimento_producto ep', 'es.experimento_producto_id=ep.id')
                ->join('producto p', 'ep.producto_id=p.id')
                ->where('ep.experimento_id=:id', array(':id'=>$id))
                ->queryAll();

                // Equipos
                $equipos = Yii::app()->db->createCommand()
                ->select('e.id, e.nombre, e.marca, e.observaciones, e.estado')
                ->from('equipo e')
                ->join('experimento_equipo ee', 'ee.equipo_id=e.id')
                ->where('ee.experimento_id=:id', array(':id'=>$id))
                ->queryAll();

                // LOGs del experimento
                $logs = $this->_log_experimento($id);

                // Información adicional del experimento
                 $info_adicional = Yii::app()->db->createCommand()
                ->select('ee.*, u.nombre as nombre_usuario')
                ->from('experimento_estado ee')
                ->join('usuario u', 'u.id=ee.usuario_id')
                ->where('ee.experimento_id=:id', array(':id'=>$id))
                ->queryAll();

                if (count($info_adicional) > 0) {
                    foreach ($info_adicional as $key => $info) {
                        $info = (object) $info;
                        $info_adicional[$key]['fecha_txt'] = $this->fecha_formato_listado($info->fecha);
                        $info_adicional[$key]['estado_txt'] = $this->estado_experimento_txt($info->estado);
                        $info_adicional[$key]['estado_icono'] = $this->estado_experimento_icono($info->estado);
                    }
                }

                $data = array(
                    'info_basica'       => $info_basica,
                    'productos'         => $productos,
                    'series'            => $series,
                    'equipos'           => $equipos,
                    'logs'              => $logs,
                    'info_adicional'    => $info_adicional
                );
            } catch (Exception $e) {
                echo 'Ha ocurrido un error: ',  $e->getMessage();
                die();
            }
                
            $this->render('view/view',array(
                    'model'=>$model,
                    'data'=>$data,
                    'tipo'=>$tipo
            ));
	}
        
        /**
         * Función para obtener los logs asociados al experimento
         * @param type $id
         * @return type
         */
        private function _log_experimento($id = 0) 
        {
            $logs = array();
            if ($id > 0) {
                $logs = Yii::app()->db->createCommand()
                ->select('*')
                ->from('log')
                ->andWhere(array('like', 'tabla', '%experimento%'))
                ->andWhere(array('like', 'relacion', '%experimento'.$id.';%'))
                ->order('id asc')
                ->queryAll();
                
                // Dar formato a los logs asociados al experimento
                $logs = $this->obtener_formato_logs($logs);
            }
            return $logs;
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $tipo = 'Experimento';
		$model=new Experimento;
                $this->add_js('js/laboratorio/experimento.js');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST[$tipo]))
		{
                    $model->attributes  = $_POST[$tipo];
                    $model->titulo      = $_POST[$tipo]['titulo'];
                    $model->descripcion = $_POST[$tipo]['descripcion'];
                    $model->condiciones = $_POST[$tipo]['condiciones'];
                    $model->resultados  = $_POST[$tipo]['resultados'];
                    $model->fecha       = date("Y-m-d H:i:s");
                    $model->usuario_id  = Yii::app()->user->id;
                    if($model->save()) {
                        $info_adicional = '';
                        $info_adicional .= 'titulo>>>'.$this->log_limpiar_texto($model->titulo);
                        $info_adicional .= ';;;descripcion>>>'.$this->log_limpiar_texto($model->descripcion);
                        $info_adicional .= ';;;condiciones>>>'.$this->log_limpiar_texto($model->condiciones);
                        $info_adicional .= ';;;resultados>>>'.$this->log_limpiar_texto($model->resultados);

                        // LOG del sistema
                        $id = $this->get_last_id('experimento');
                        $log_params = array(
                            'accion'    => 'ALTA',
                            'tabla'     => 'experimento',
                            'id'        => $id,
                            'relacion'  => 'experimento'.$id.';',
                            'info'      => $info_adicional
                        );
                        $this->log($log_params);

                        // Redirigir a la pantalla de confirmación de la creación
                        $this->redirect(array('createConfirm','id'=>$id));
                    }
		}

		$this->render('create/create',array(
			'model'=>$model,
                        'tipo'=>$tipo
		));
	}
        
        /**
         * Mostrar la pantalla de confirmación de creación
         * @param type $id
         */
        public function actionCreateConfirm($id) 
        {
            $model=$this->loadModel($id);

            // En caso de estado distinto de INICIADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$id));
            }
            else {
                $this->_confirmar_accion('creacion', $id);
            }
        }
        
        /**
         * Mostrar la pantalla de confirmación de edición
         * @param type $id
         */
        public function actionUpdateConfirm($id) 
        {
            $model=$this->loadModel($id);
            
            // En caso de estado FINALIZADO, redirigir a Detalles
            if ($model->estado == 'FINALIZADO') {
                $this->redirect(array('view','id'=>$id));
            }
            else {
                $this->_confirmar_accion('edicion', $id);
            }
        }
        
        /**
         * Mostrar la pantalla de confirmación de Productos
         * @param type $id
         */
        public function actionProductosConfirm($id) 
        {
            $model=$this->loadModel($id);
            
            // En caso de estado FINALIZADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$id));
            }
            else {
                $this->_confirmar_accion('productos', $id);
            }
        }
        
        /**
         * Mostrar la pantalla de confirmación de Series
         * @param type $id
         */
        public function actionSeriesConfirm($id) 
        {
            $model=$this->loadModel($id);
            
            // En caso de estado FINALIZADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$id));
            }
            else {
                $this->_confirmar_accion('series', $id);
            }
        }
        
        /**
         * Mostrar la pantalla de confirmación de Equipos
         * @param type $id
         */
        public function actionEquiposConfirm($id) 
        {
            $model=$this->loadModel($id);
            
            // En caso de estado FINALIZADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$id));
            }
            else {
                $this->_confirmar_accion('equipos', $id);
            }
        }
        
        /**
         * Mostrar la pantalla de confirmación de Cambiar Estado
         * @param type $id
         */
        public function actionCambiarEstadoConfirm($id) 
        {
            $model=$this->loadModel($id);
            
            // En caso de estado INICIADO, redirigir a Detalles
            if ($model->estado == 'INICIADO') {
                $this->redirect(array('view','id'=>$id));
            }
            else {
                $this->_confirmar_accion('cambiar_estado', $id);
            }
        }
        
        /**
	 * Función genérica para mostrar por pantalla
         * la confirmación de una acción.
         * Ejemplo: creacion, edicion, productos, series, equipos
	 */
	private function _confirmar_accion($accion, $id)
	{
            $tipo = 'Experimento';
            $model=$this->loadModel($id);
            
            // Verificar que el experimento no este finalizado
            if ($model->estado != 'FINALIZADO') {
                // Obtener el mensaje de confirmación
                $mensaje = $this->_mensaje_confirmacion($accion, $model->estado);
                // Cargar la información básica del experimento
                $info_basica = $this->_info_basica_experimento($id);
                $data = array(
                    'mensaje'       => $mensaje,
                    'info_basica'   => $info_basica
                );
                // Renderizar la vista
                $this->render('confirm',array(
                    'model'=>$model,
                    'data'=>$data,
                    'tipo'=>$tipo
                ));
            }
            else {
                $this->redirect(array('view','id'=>$model->id));
            }
	}
        
        private function _mensaje_confirmacion($accion, $estado)
        {
            // Controlar las distintas acciones:
            $mensaje = (object) null;
            switch ($accion) {
                case 'creacion':
                default:
                    $mensaje->titulo = 'El experimento se ha creado correctamente.';
                    $mensaje->icono = 'icon-check-sign';
                    $mensaje->wizard_active = 'info_inicial';
                    $mensaje->opciones = array(
                        'volver_editar',
                        'agregar_productos',
                        'experimentos'
                    );
                    break;
                case 'edicion':
                    $mensaje->titulo = 'El experimento se ha editado correctamente.';
                    $mensaje->icono = 'icon-check-sign';
                    $mensaje->wizard_active = 'info_inicial';
                    $mensaje->opciones = array(
                        'volver_editar',
                        'agregar_productos',
                        'experimentos'
                    );
                    break;
                case 'productos':
                    $mensaje->titulo = 'Se han agregado productos al experimento correctamente.';
                    $mensaje->icono = 'icon-check-sign';
                    $mensaje->wizard_active = 'productos';
                    $mensaje->opciones = array(
                        'volver_productos',
                        'cargar_series',
                        'experimentos'
                    );
                    break;
                case 'series':
                    $mensaje->titulo = 'Se han cargado las series al experimento correctamente.';
                    $mensaje->icono = 'icon-check-sign';
                    $mensaje->wizard_active = 'series';
                    $mensaje->opciones = array(
                        'volver_series',
                        'agregar_equipos',
                        'experimentos'
                    );
                    break;
                case 'equipos':
                    $mensaje->titulo = 'Se han agregado equipos al experimento correctamente.';
                    $mensaje->icono = 'icon-check-sign';
                    $mensaje->wizard_active = 'equipos';
                    $mensaje->opciones = array(
                        'volver_equipos',
                        'verificar_informacion',
                        'experimentos'
                    );
                    break;
                case 'cambiar_estado':
                    $mensaje->titulo = 'El experimento ha cambiado de estado correctamente.';
                    $mensaje->icono = 'icon-check-sign';
                    $mensaje->wizard_active = 'verificar';
                    $mensaje->opciones = array(
                        'agregar_informacion',
                        'experimentos'
                    );
                    break;
            }
            // En caso de Estado no INICIADO, las opciones disponibles son las siguientes
            if ($estado != 'INICIADO' and $accion != 'cambiar_estado') {
                $mensaje->opciones = array('volver_editar', 'experimentos');
            }
            return $mensaje;
        }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
            $tipo = 'Experimento';
            $model=$this->loadModel($id);
            $this->add_js('js/laboratorio/experimento.js');
            
            // En caso de estado FINALIZADO, redirigir a Detalles
            if ($model->estado == 'FINALIZADO') {
                $this->redirect(array('view','id'=>$model->id));
            }

            if(isset($_POST[$tipo]))
            {
                // 1) Verificar los cambios realizados en los campos del experimento
                $cambios = '';
                $campo = 'titulo';
                if ($model->$campo != $_POST[$tipo][$campo]) {
                    $cambios .= $campo.'<<<'.$this->log_limpiar_texto($model->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo][$campo]);
                }
                $campo = 'descripcion';
                if ($model->$campo != $_POST[$tipo][$campo]) {
                    if ($cambios != '') $cambios .= ';;;';
                    $cambios .= $campo.'<<<'.$this->log_limpiar_texto($model->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo][$campo]);
                }
                $campo = 'condiciones';
                if ($model->$campo != $_POST[$tipo][$campo]) {
                    if ($cambios != '') $cambios .= ';;;';
                    $cambios .= $campo.'<<<'.$this->log_limpiar_texto($model->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo][$campo]);
                }
                $campo = 'resultados';
                if ($model->$campo != $_POST[$tipo][$campo]) {
                    if ($cambios != '') $cambios .= ';;;';
                    $cambios .= $campo.'<<<'.$this->log_limpiar_texto($model->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo][$campo]);
                }

                // 2) Asignar los nuevos valores al experimento
                $model->attributes  = $_POST[$tipo];
                $model->titulo      = $_POST[$tipo]['titulo'];
                $model->descripcion = $_POST[$tipo]['descripcion'];
                $model->condiciones = $_POST[$tipo]['condiciones'];
                $model->resultados  = $_POST[$tipo]['resultados'];

                // 3) Guardar los cambios
                if($model->save()) {
                    // LOG del sistema
                    $log_params = array(
                        'accion'    => 'MODIFICACION',
                        'tabla'     => 'experimento',
                        'id'        => $id,
                        'relacion'  => 'experimento'.$id.';',
                        'info'      => $cambios
                    );
                    $this->log($log_params);
                    
                    // 4) Regirigir a la página de confirmación de modificación
                    $this->redirect(array('updateConfirm','id'=>$id));
                }
            }

            $this->render('update',array(
                    'model'=>$model,
                    'tipo'=>$tipo
            ));
	}

	/**
	 * Mostrar el panel de administración de Gestión de Experimentos.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Función para mostrar el panel de administración de Gestión de Experimentos
	 */
	public function actionAdmin()
	{
            $this->layout='//layouts/listado';
            $this->add_js('js/laboratorio/experimento.js');
            $this->add_js('assets/bootstrap-datepicker/js/bootstrap-datepicker.js');
            
            // Obtener los usuarios
            $usuarios = Yii::app()->db->createCommand()
            ->select('u.id, u.nombre')
            ->from('usuario u')
            ->andWhere('u.estado=1')
            //->andWhere('u.rol_id>1')
            ->order('u.nombre asc')
            ->queryAll();
            $data['usuarios'] = $usuarios;

            $this->render('admin/admin',array('data'=>$data));
	}
        
        /**
         * Función para mostrar el listado de experimentos
         */
        public function actionListadoExperimentos() 
        {
            // Obtener todos los experimentos
            $experimentos = Experimento::model()->findAll();
            $this->renderPartial('admin/_listado',array(
                'experimentos'=>$experimentos
            ));
        }
        
        /**
         * Función para mostrar el resumen de la cantidad de experimentos en cada estado
         */
        public function actionResumenExperimentos() 
        {
            // Obtener todos los experimentos
            $experimentos = Experimento::model()->findAll();
            
            $cant_iniciados = $cant_preparados = $cant_en_curso = $cant_finalizados = 0;
            
            if (count($experimentos) > 0) {
                foreach ($experimentos as $e) {
                    switch ($e->estado) {
                        case 'INICIADO':    $cant_iniciados++;  break;
                        case 'PREPARADO':   $cant_preparados++; break;
                        case 'EN_CURSO':    $cant_en_curso++;   break;
                        case 'FINALIZADO':  $cant_finalizados++;break;
                    }
                }
            }
            
            $cantidad = array(
                'TOTAL'         => count($experimentos),
                'INICIADO'      => $cant_iniciados,
                'PREPARADO'     => $cant_preparados,
                'EN_CURSO'      => $cant_en_curso,
                'FINALIZADO'    => $cant_finalizados,
            );
            
            $icono = array(
                'INICIADO'      => $this->estado_experimento_icono('INICIADO'),
                'PREPARADO'     => $this->estado_experimento_icono('PREPARADO'),
                'EN_CURSO'      => $this->estado_experimento_icono('EN_CURSO'),
                'FINALIZADO'    => $this->estado_experimento_icono('FINALIZADO')
            );
            
            $this->renderPartial('admin/_resumen',array(
                'cantidad'=>$cantidad,
                'icono'=>$icono
            ));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Experimento::model()->findByPk($id);
		if($model===null) {
                    throw new CHttpException(404,'La página que se esta buscando no existe.');
                }
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
            if(isset($_POST['ajax']) && $_POST['ajax']==='experimento-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        /**
         * Función para generar los criterios para consultas a DB
         * @param type $type
         * @param type $params array(':user_id'=>$id)
         * @return \CDbCriteria
         */
        public function criteria($type = '', $params = array()) {
            $criteria = new CDbCriteria;
            switch ($type) {
                case 'experimentos_iniciados':
                    $criteria->select = array(
                        't.*'
                        );
                    $criteria->addCondition('t.estado = \'INICIADO\'');
                    $criteria->params = $params;
                    break;
                case 'experimentos_en_curso':
                    $criteria->select = array(
                        't.*'
                        );
                    $criteria->addCondition('t.estado = \'PREPARADO\' OR t.estado = \'EN_CURSO\'');
                    $criteria->params = $params;
                    break;
                case 'experimentos_finalizados':
                    $criteria->select = array(
                        't.*'
                        );
                    $criteria->addCondition('t.estado = \'FINALIZADO\'');
                    $criteria->params = $params;
                    break;
            }
            return $criteria;
        }
        
        
        /* ------------- PASO 2: PRODUCTOS ---------------- */
        
        
        public function actionAgregarProductos($id)
	{
            $this->layout='//layouts/listado';
            $tipo = 'Experimento';
            $model = $this->loadModel($id);
            $this->add_js('js/laboratorio/experimento.js');

            // En caso de estado distinto de INICIADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$model->id));
            }

            $tipo_productos = Yii::app()->db->createCommand()
            ->select('tp.id, tp.nombre')
            ->from('tipo_producto tp')
            ->where('tp.estado=1')
            ->order('tp.nombre asc')
            ->queryAll();

            $this->render('create/productos/agregar_productos',array(
                    'model'=>$model,
                    'tipo_productos'=>$tipo_productos,
                    'tipo'=>$tipo
            ));
	}

        /**
         * Función para buscar productos y mostrar el resultado en un listado
         */
        public function actionBuscarProductos() 
        {
            $id             = $_POST['codigo'];
            $experimento_id = $_POST['experimento_id'];
            $nombre         = $_POST['nombre'];
            $tipo           = $_POST['tipo'];
            
            // Obtener los productos ya agregados al experimento
            $command = Yii::app()->db->createCommand()
            ->select('ep.producto_id, ep.cantidad')
            ->from('experimento_producto ep')
            ->where('ep.experimento_id = :experimento_id', array(':experimento_id'=>$experimento_id));
            $seleccionados_db = $command->queryAll();
            $seleccionados = array();
            $cantidades = array();
            if (count($seleccionados_db) > 0) {
                foreach ($seleccionados_db as $r) {
                    $producto_id = $r['producto_id'];
                    array_push($seleccionados, $producto_id);
                    $cantidades[$producto_id] = $r['cantidad'];
                }
            }

            // Obtener los productos filtrados
            $command->reset();
            $command->select('p.id, p.nombre, tp.nombre as tipo, p.usa_serie, s.cantidad, pd.fraccion, pd.unidad_medida')
            ->from('producto p')
            ->join('stock s', 's.producto_id=p.id')
            ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
            ->leftJoin('producto_detalle pd', 'pd.producto_id=p.id');
            if ($id > 0) $command->andWhere('p.id=:id', array(':id'=>$id));
            if ($nombre != '') $command->andWhere(array('like', 'p.nombre', '%'.$nombre.'%'));
            if ($tipo > 0) $command->andWhere('p.tipo_producto_id='.$tipo);
            $productos = $command->queryAll();

            $this->renderPartial('create/productos/_busqueda_productos',array(
                'productos'=>$productos,
                'seleccionados'=>$seleccionados,
                'cantidades'=>$cantidades
            ));
        }
        
        /**
         * Función para mostrar el listado de productos asociados al experimento
         * @param type $id
         */
        public function actionProductosPorExperimento($id) 
        {
            $productos = Yii::app()->db->createCommand()
            ->select('p.id, p.nombre, tp.nombre as tipo, ep.producto_usa_serie, ep.cantidad, pd.fraccion, pd.unidad_medida')
            ->from('producto p')
            ->join('experimento_producto ep', 'ep.producto_id=p.id')
            ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
            ->leftJoin('producto_detalle pd', 'pd.producto_id=p.id')
            ->where('ep.experimento_id=:id', array(':id'=>$id))
            ->queryAll();
            
            $this->renderPartial('create/productos/_productos_por_experimento',array(
                    'productos' => $productos
            ));
        }
        
        /**
         * Función para asociar un producto al experimento
         */
        public function actionAgregarProducto() 
        {
            $producto_id    = $_POST['id'];
            $cantidad       = $_POST['cantidad'];
            $disponible     = $_POST['disponible'];
            $serie          = $_POST['serie'];
            $experimento_id = $_POST['experimento_id'];
            
            if ($producto_id > 0 && $cantidad > 0 && $cantidad <= $disponible && $experimento_id > 0) {
                // Obtener el último precio pagado por el producto en un renglón de compra
                $subtotal = Yii::app()->db->createCommand(array(
                    'select' => array('precio'),
                    'from' => 'renglon_compra',
                    'where' => 'producto_id=:id',
                    'params' => array(':id'=>$producto_id),
                    'order'=>'id desc'
                ))->queryRow();
                $subtotal = $subtotal['precio'];
                $costo = $subtotal * $cantidad;

                // Producto a insertar en DB
                $experimento_producto = array(
                    'experimento_id' => $experimento_id,
                    'producto_id' => $producto_id,
                    'producto_usa_serie' => $serie,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'costo' => $costo
                );
                $command = Yii::app()->db->createCommand();
                $command->insert('experimento_producto', $experimento_producto);
                
                // LOG del sistema
                $id = $this->get_last_id('experimento_producto');
                $info_adicional = 'experimento_id>>>'.$experimento_id.';;;producto_id>>>'.$producto_id;
                $relacion = 'experimento'.$experimento_id.';producto'.$producto_id.';';
                $log_params = array(
                    'accion'    => 'ALTA',
                    'tabla'     => 'experimento_producto',
                    'id'        => $id,
                    'relacion'  => $relacion,
                    'info'      => $info_adicional
                );
                $this->log($log_params);
            }
            $this->actionProductosPorExperimento($experimento_id);
        }
        
        /**
         * Función para eliminar un producto del experimento
         */
        public function actionEliminarProducto() 
        {
            $producto_id    = $_POST['id'];
            $experimento_id = $_POST['experimento_id'];
            
            if ($producto_id > 0 && $experimento_id > 0) {
                // Función para eliminar un producto del experimento (quitando consumos y series)
                $this->_eliminar_producto_por_experimento($producto_id, $experimento_id);
            }
            $this->actionProductosPorExperimento($experimento_id);
        }
        
        /**
         * Función para eliminar un producto de un experimento
         * Quitando los consumos asociados y las series asignadas
         * @param type $producto_id
         * @param type $experimento_id
         */
        private function _eliminar_producto_por_experimento($producto_id = 0, $experimento_id = 0) 
        {
            $command = Yii::app()->db->createCommand();
            // 1) Obtener el consumo asociado al experimento
            $consumo = $command->select('id, total')
                    ->from('consumo')
                    ->where('experimento_id='.$experimento_id)
                    ->queryRow();
            
            if ($consumo) {
                $consumo = (object) $consumo;
                
                // 2) Obtener el renglon_consumo asociado al producto y al consumo
                $command->reset();
                $renglon_consumo = $command->select('id, subtotal')
                        ->from('renglon_consumo')
                        ->where('consumo_id='.$consumo->id.' AND producto_id='.$producto_id)
                        ->queryRow();
                
                if ($renglon_consumo) {
                    $rc = (object) $renglon_consumo;
                    // 3) Modificar el consumo asociado al experimento
                    $total = $consumo->total - $rc->subtotal;
                    $command->reset();
                    $command->update('consumo', array(
                        'total' => $total
                    ), 'id=:id', array(':id'=>$consumo->id));

                    // LOG del sistema
                    $info_adicional = 'total<<<'.$consumo->total.';;;total>>>'.$total;
                    $relacion = 'consumo'.$consumo->id.';';
                    $log_params = array(
                        'accion'    => 'MODIFICACION',
                        'tabla'     => 'consumo',
                        'id'        => $consumo->id,
                        'relacion'  => $relacion,
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);
                }

                // 4) Obtener la relación entre el experimento y el producto
                $command->reset();
                $experimento_producto = (object) $command->select('id, producto_usa_serie')
                        ->from('experimento_producto')
                        ->where('experimento_id='.$experimento_id.' AND producto_id='.$producto_id)
                        ->queryRow();

                // 5) Verificar si el producto asociado al experimento utiliza series
                if ($experimento_producto->producto_usa_serie) {

                    // 6) Quitar asignación a todas las series asociadas al renglon de consumo
                    if ($renglon_consumo) {
                        $command->reset();
                        $command->update('serie', array(
                            'renglon_consumo_id' => NULL
                        ), 'renglon_consumo_id='.$rc->id);
                    }

                    // 7) Eliminar todas las series asociadas al experimento para este producto
                    $command->reset();
                    $command->delete('experimento_serie', 
                        'experimento_producto_id='.$experimento_producto->id
                    );
                    
                    // 8) LOG del sistema
                    $info_adicional = 'experimento_id>>>'.$experimento_id.';;;producto_id>>>'.$producto_id;
                    $relacion = 'experimento'.$experimento_id.';producto'.$producto_id.';';
                    $log_params = array(
                        'accion'    => 'BAJA',
                        'tabla'     => 'experimento_serie',
                        'id'        => NULL,
                        'relacion'  => $relacion,
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);
                }

                // 9) Eliminar el renglon de consumo asociado al producto
                if ($renglon_consumo) {
                    $command->reset();
                    $command->delete('renglon_consumo', 
                        'id=:id',
                        array(':id'=> $rc->id)
                    );
                }
            }
            
            // 10) Eliminar el producto asociado al experimento
            $command->reset();
            $command->delete('experimento_producto', 
                'experimento_id = :experimento_id AND producto_id = :producto_id',
                array(  ':experimento_id'   => $experimento_id,
                        ':producto_id'      => $producto_id)
            );
            
            // 11) LOG del sistema
            $info_adicional = 'experimento_id>>>'.$experimento_id.';;;producto_id>>>'.$producto_id;
            $relacion = 'experimento'.$experimento_id.';producto'.$producto_id.';';
            $log_params = array(
                'accion'    => 'BAJA',
                'tabla'     => 'experimento_producto',
                'id'        => NULL,
                'relacion'  => $relacion,
                'info'      => $info_adicional
            );
            $this->log($log_params);
        }
        
        public function actionAgregarMultiplesProductos()
        {
            die(var_dump($_POST));
            if(Yii::app()->request->isPostRequest) {
                $experimento_id = $_POST['experimento_id'];
                $productos = $_POST['productos'];
                foreach ($productos as $producto) {
                    $producto = (object) $p;
                    $this->agregar_producto($producto, $experimento_id);
                }
                        
                        $producto_id    = $_POST['id'];
                        $cantidad       = $_POST['cantidad'];
                        $disponible     = $_POST['disponible'];
                        $serie          = $_POST['serie'];
            
            }
        }
        
        /* ------------- PASO 3: SERIES ---------------- */
        
        /**
         * Función para mostrar la vista que permite asociar las series a los productos
         * @param type $id
         */
        public function actionCargarSeries($id) 
        {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                // 1) Cargar los datos básicos de la vista que permite cargar series
                $this->layout='//layouts/listado';
                $tipo = 'Experimento';
                $model = $this->loadModel($id);
                
                // En caso de estado distinto de INICIADO, redirigir a Detalles
                if ($model->estado != 'INICIADO') {
                    $this->redirect(array('view','id'=>$model->id));
                }
            
                $this->add_js('js/laboratorio/experimento.js');
                $this->add_js('assets/jquery-multi-select/js/jquery.multi-select.js');
                // Bandera para habilitar la carga de series
                $cargar_series = false;

                // 2) Obtener los productos asignados al experimento
                $productos = Yii::app()->db->createCommand()
                ->select('p.id, p.nombre, ep.producto_usa_serie, ep.cantidad')
                ->from('producto p')
                ->join('experimento_producto ep', 'ep.producto_id=p.id')
                ->where('ep.experimento_id=:id', array(':id'=>$id))
                ->queryAll();
                
                // 3) Recorrer los productos, y por cada uno, obtener las series asociadas
                foreach ($productos as $key => $p) {
                    $p = (object) $p;
                    if ($p->producto_usa_serie) {
                        $cargar_series = true;

                        // 4) Obtener todas las series asociadas al producto
                        $p->series = Yii::app()->db->createCommand()
                        ->select('s.serie, s.vencimiento, s.renglon_consumo_id')
                        ->from('serie s')
                        ->where('s.producto_id=:id', array(':id'=>$p->id))
                        ->order('vencimiento asc')
                        ->queryAll();
                        
                        // 5) Generar un array con las series utilizadas por todos los experimentos
                        $series_utilizadas = array();
                        foreach ($p->series as $s) {
                            if ($s['renglon_consumo_id'] != NULL)
                                array_push($series_utilizadas, $s['serie']);
                        }
                        
                        // 6) Obtener todas las series asociadas al producto para este experimento
                        $series_asignadas_db = Yii::app()->db->createCommand()
                        ->select('s.serie')
                        ->from('serie s')
                        ->join('experimento_serie es', 'es.serie=s.serie')
                        ->join('experimento_producto ep', 'ep.id=es.experimento_producto_id')   
                        ->where('s.producto_id='.$p->id.' AND ep.experimento_id='.$id.' AND ep.producto_id='.$p->id)
                        ->queryAll();
                        
                        $series_asignadas = array();
                        foreach ($series_asignadas_db as $s) {
                            array_push($series_asignadas, $s['serie']);
                        }
                        
                        // 7) Recorrer el array de series y marcar las series asignadas en el array de series asignadas y descartar las series utilizadas en otros experimentos
                        $p->cantidad_asignada = 0;
                        foreach ($p->series as $key2 => $s) {
                            $asignada = false;
                            if (count($series_asignadas) > 0) {
                                // Seleccionar la serie asignada
                                if (in_array($s['serie'], $series_asignadas)) {
                                    $p->series[$key2]['selected'] = true;
                                    $p->cantidad_asignada++;
                                    $asignada = true;
                                }
                            }
 
                            if (!$asignada) {
                                // Descartar la serie utilizada
                                if (in_array($s['serie'], $series_utilizadas)) {
                                    unset($p->series[$key2]);
                                }
                            }
                        }
                        
                        // 8) Agrupar las series por vencimiento
                        $series_vencimientos = array();
                        foreach ($p->series as $s) {
                            $s = (object) $s;
                            $series_vencimientos[$s->vencimiento][] = $s;
                        }
                        $p->series = $series_vencimientos;
                    }
                    
                    $productos[$key] = $p;
                }

                // 8) Cargar el array de datos para la vista
                $data['productos']      = $productos;
                $data['cargar_series']  = $cargar_series;

                // 9) Mostrar las vistas que permite cargar series
                $this->render('create/series/cargar_series',array(
                        'model'=>$model,
                        'tipo'=>$tipo,
                        'data'=>$data
                ));
            }
            else { // Procesar el formulario proveniente del POST
                $this->_cargarSeriesProceso();
            }
        }
        
        /**
         * Funcion para procesar el formulario de SERIES asociadas al experimento
         */
        private function _cargarSeriesProceso() 
        {
            $productos_series = $_POST['series'];
            $experimento_id = $_POST['experimento_id'];
            $total = 0;
            $consumo_total = 0;

            // ID del usuario
            $usuario_id = Yii::app()->user->id;

            // 1) Obtener los productos asignados al experimento
            $command = Yii::app()->db->createCommand();
            $productos = $command->select('ep.id as experimento_producto_id, p.id, ep.producto_usa_serie, ep.cantidad, rc.precio')
            ->from('producto p')
            ->join('experimento_producto ep', 'ep.producto_id=p.id')
            ->join('renglon_compra rc', 'rc.producto_id=p.id')
            ->where('ep.experimento_id=:id', array(':id'=>$experimento_id))
            ->queryAll();
            
            if (count($productos) > 0) {
                // 2) Obtener si existe, el consumo asociado al experimento
                $command->reset();
                $consumo = $command->select('id, total')
                ->from('consumo')
                ->where('experimento_id='.$experimento_id)
                ->queryRow();
                if ($consumo) {
                    $consumo_id = $consumo['id'];
                    $consumo_total = $consumo['total'];
                    $accion_consumo = 'MODIFICACION';
                }
                else {
                    // 3) Si no existe consumo, crear un nuevo registro en la tabla consumo con total = 0
                    $consumo = array(
                        'tipo' => 'EXPERIMENTO',
                        'consumidor_id'     => $usuario_id,
                        'experimento_id'    => $experimento_id,
                        'total'             => $consumo_total
                    );
                    $command->reset();
                    $command->insert('consumo', $consumo);
                    $consumo_id = $this->get_last_id('consumo');
                    $accion_consumo = 'ALTA';
                }

                // Recorrer todos los productos asociados al experimento
                foreach ($productos as $p) {
                    $p = (object) $p;
                    $subtotal = $p->cantidad * $p->precio; // Calcular el subtotal
                    $total += $subtotal; // Realizar la suma de los precios de cada producto
                    
                    // 4) Para cada producto, verificar si existe un renglon de consumo asociado
                    $command->reset();
                    $renglon_consumo = $command->select('id')
                    ->from('renglon_consumo')
                    ->where('consumo_id='.$consumo_id.' AND producto_id='.$p->id)
                    ->queryRow();
                    if ($renglon_consumo) {
                        $renglon_consumo_id = $renglon_consumo['id'];
                    }
                    else {
                        // 5) Si no existe, para cada experimento, asignar un registro en la tabla renglon_consumo
                        $renglon_consumo = array(
                            'cantidad' => $p->cantidad,
                            'subtotal' => $subtotal,
                            'producto_id' => $p->id,
                            'consumo_id' => $consumo_id
                        );
                        $command->reset();
                        $command->insert('renglon_consumo', $renglon_consumo);
                        $renglon_consumo_id = $this->get_last_id('renglon_consumo');
                    }

                    // 6) Verificar si el producto tiene series asignadas
                    if (isset($productos_series[$p->id])) {
                        
                        // 7) Poner en NULL todas las series asociadas al renglon de consumo
                        $command->reset();
                        $command->update('serie', array(
                            'renglon_consumo_id' => NULL
                        ), 'renglon_consumo_id='.$renglon_consumo_id);
                        
                        // 8) Eliminar las relaciones entre serie y experimento_producto
                        $command->reset();
                        $command->delete('experimento_serie', 'experimento_producto_id='.$p->experimento_producto_id);
                        
                        // 9) LOG del sistema
                        $info_adicional = 'experimento_id>>>'.$experimento_id.';;;producto_id>>>'.$p->id;
                        $relacion = 'experimento'.$experimento_id.';producto'.$p->id.';';
                        $log_params = array(
                            'accion'    => 'BAJA',
                            'tabla'     => 'experimento_serie',
                            'id'        => NULL,
                            'relacion'  => $relacion,
                            'info'      => $info_adicional
                        );
                        $this->log($log_params);
                        
                        foreach ($productos_series[$p->id] as $i => $serie) {
                            // 10) Por cada serie, asignar el renglón de consumo en la tabla series
                            $command->reset();
                            $command->update('serie', array(
                                'renglon_consumo_id' => $renglon_consumo_id
                            ), 'serie=:serie', array(':serie'=>$serie));

                            // 11) Agregar la relación entre la serie y el experimento_producto
                            $experimento_serie = array(
                                'serie' => $serie,
                                'experimento_id' => $experimento_id,
                                'experimento_producto_id' => $p->experimento_producto_id
                            );
                            $command->reset();
                            $command->insert('experimento_serie', $experimento_serie);
                            
                            // 12) LOG del sistema
                            $experimento_serie_id = $this->get_last_id('experimento_serie');
                            $info_adicional = 'experimento_id>>>'.$experimento_id.';;;serie>>>'.$serie;
                            $relacion = 'experimento'.$experimento_id.';serie'.$serie.';';
                            $log_params = array(
                                'accion'    => 'ALTA',
                                'tabla'     => 'experimento_serie',
                                'id'        => $experimento_serie_id,
                                'relacion'  => $relacion,
                                'info'      => $info_adicional
                            );
                            $this->log($log_params);
                        }
                    }
                }

                // 13) Cargar el total consumido y la fecha actual en la tabla consumo
                $command->reset();
                $command->update('consumo', array(
                    'total' => $total,
                    'fecha' => date("Y-m-d H:i:s")
                ), 'id=:id', array(':id'=>$consumo_id));
                
                // 14) Cargar el total consumido en la tabla experimento
                $command->reset();
                $command->update('experimento', array(
                    'total' => $total,
                ), 'id=:id', array(':id'=>$experimento_id));

                // 15) LOG del sistema
                $info_adicional = 'total<<<'.$consumo_total.';;;total>>>'.$total;
                $relacion = 'consumo'.$consumo_id.';';
                $log_params2 = array(
                    'accion'    => $accion_consumo,
                    'tabla'     => 'consumo',
                    'id'        => $consumo_id,
                    'relacion'  => $relacion,
                    'info'      => $info_adicional
                );
                $this->log($log_params2);
                
                $info_adicional = 'total<<<'.$consumo_total.';;;total>>>'.$total;
                $relacion = 'experimento'.$experimento_id.';';
                $log_params3 = array(
                    'accion'    => 'MODIFICACION',
                    'tabla'     => 'experimento',
                    'id'        => $experimento_id,
                    'relacion'  => $relacion,
                    'info'      => $info_adicional
                );
                $this->log($log_params3);
            }

            // 16) Redirigir al siguiente paso de la creación del experimento
            $this->redirect(array('seriesConfirm','id'=>$experimento_id));
        }
        
        /* ------------- PASO 4: EQUIPOS ---------------- */
        
        /**
         * Función para mostrar la pantalla que permite asociar equipos al experimento
         * @param type $id
         */
        public function actionAgregarEquipos($id)
	{
            $this->layout='//layouts/listado';
            $tipo = 'Experimento';
            $model = $this->loadModel($id);
            $this->add_js('js/laboratorio/experimento.js');

            // En caso de estado distinto de INICIADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$model->id));
            }

            $this->render('create/equipos/agregar_equipos',array(
                    'model'=>$model,
                    'tipo'=>$tipo
            ));
	}
        
        /**
         * Función para buscar equipos y mostrar el resultado en un listado
         */
        public function actionBuscarEquipos() 
        {
            $experimento_id = $_POST['experimento_id'];
            $nombre         = $_POST['nombre'];
            $marca          = $_POST['marca'];
            $estado         = $_POST['estado'];

            // Obtener los equipos ya agregados al experimento
            $command = Yii::app()->db->createCommand()
            ->select('ee.equipo_id')
            ->from('experimento_equipo ee')
            ->where('ee.experimento_id = :experimento_id', array(':experimento_id'=>$experimento_id));
            $seleccionados_db = $command->queryAll();
            $seleccionados = array();
            if (count($seleccionados_db) > 0) {
                foreach ($seleccionados_db as $r) {
                    array_push($seleccionados, $r['equipo_id']);
                }
            }

            // Obtener los equipos filtrados
            $command->reset();
            $command->select('e.id, e.nombre, e.marca, e.observaciones, e.estado')
            ->from('equipo e');
            if ($nombre != '') $command->andWhere(array('like', 'e.nombre', '%'.$nombre.'%'));
            if ($marca != '') $command->andWhere(array('like', 'e.marca', '%'.$marca.'%'));
            if ($estado != '') $command->andWhere('e.estado = \''.$estado.'\'');
            $equipos = $command->queryAll();

            $this->renderPartial('create/equipos/_busqueda_equipos',array(
                'equipos'=>$equipos,
                'seleccionados'=>$seleccionados
            ));
        }
        
        /**
         * Función para mostrar el listado de equipos asociados al experimento
         * @param type $id
         */
        public function actionEquiposPorExperimento($id) 
        {
            $equipos = Yii::app()->db->createCommand()
            ->select('e.id, e.nombre, e.marca, e.observaciones, e.estado')
            ->from('equipo e')
            ->join('experimento_equipo ee', 'ee.equipo_id=e.id')
            ->where('ee.experimento_id=:id', array(':id'=>$id))
            ->queryAll();
            
            $this->renderPartial('create/equipos/_equipos_por_experimento',array(
                    'equipos' => $equipos
            ));
        }
        
        /**
         * Función para asociar un equipo al experimento
         */
        public function actionAgregarEquipo() 
        {
            $equipo_id      = $_POST['id'];
            $experimento_id = $_POST['experimento_id'];
            
            if ($equipo_id > 0 && $experimento_id > 0) {
                // Equipo a insertar en DB
                $experimento_equipo = array(
                    'experimento_id' => $experimento_id,
                    'equipo_id' => $equipo_id
                );
                $command = Yii::app()->db->createCommand();
                $command->insert('experimento_equipo', $experimento_equipo);
                
                // LOG del sistema
                $id = $this->get_last_id('experimento_equipo');
                $info_adicional = 'experimento_id>>>'.$experimento_id.';;;equipo_id>>>'.$equipo_id;
                $relacion = 'experimento'.$experimento_id.';equipo'.$equipo_id.';';
                $log_params = array(
                    'accion'    => 'ALTA',
                    'tabla'     => 'experimento_equipo',
                    'id'        => $id,
                    'relacion'  => $relacion,
                    'info'      => $info_adicional
                );
                $this->log($log_params);
            }
            $this->actionEquiposPorExperimento($experimento_id);
        }
        
        /**
         * Función para eliminar un equipo del experimento
         */
        public function actionEliminarEquipo() 
        {
            $equipo_id      = $_POST['id'];
            $experimento_id = $_POST['experimento_id'];
            
            if ($equipo_id > 0 && $experimento_id > 0) {
                
                // Eliminar el equipo asociado al experimento
                $command = Yii::app()->db->createCommand();
                $command->delete('experimento_equipo', 
                    'experimento_id = :experimento_id AND equipo_id = :equipo_id',
                    array(  ':experimento_id'   => $experimento_id,
                            ':equipo_id'        => $equipo_id)
                );
                
                // LOG del sistema
                $id = $this->get_last_id('experimento_equipo');
                $info_adicional = 'experimento_id>>>'.$experimento_id.';;;equipo_id>>>'.$equipo_id;
                $relacion = 'experimento'.$experimento_id.';equipo'.$equipo_id.';';
                $log_params = array(
                    'accion'    => 'BAJA',
                    'tabla'     => 'experimento_equipo',
                    'id'        => $id,
                    'relacion'  => $relacion,
                    'info'      => $info_adicional
                );
                $this->log($log_params);
            }
            $this->actionEquiposPorExperimento($experimento_id);
        }
        
        /* ------------- PASO 5: VERIFICAR INFORMACION ---------------- */
        
        /**
         * Función para mostrar la pantalla que permite verificar la infomación asociada al experimento
         * @param type $id
         */
        public function actionVerificarInformacion($id)
	{
            $this->layout='//layouts/listado';
            $tipo = 'Experimento';
            $model = $this->loadModel($id);
            $this->add_js('js/laboratorio/experimento.js');

            // En caso de estado distinto de INICIADO, redirigir a Detalles
            if ($model->estado != 'INICIADO') {
                $this->redirect(array('view','id'=>$model->id));
            }

            // Productos
            $productos = Yii::app()->db->createCommand()
            ->select('p.id, p.nombre, tp.nombre as tipo, ep.producto_usa_serie, ep.cantidad, pd.unidad_medida, pd.fraccion')
            ->from('producto p')
            ->join('experimento_producto ep', 'ep.producto_id=p.id')
            ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
            ->leftJoin('producto_detalle pd', 'pd.producto_id=p.id')
            ->where('ep.experimento_id=:id', array(':id'=>$id))
            ->queryAll();

            // Series
            $series = Yii::app()->db->createCommand()
            ->select('s.vencimiento, es.serie, p.id, p.nombre')
            ->from('experimento_serie es')
            ->join('serie s', 's.serie=es.serie')
            ->join('experimento_producto ep', 'es.experimento_producto_id=ep.id')
            ->join('producto p', 'ep.producto_id=p.id')
            ->where('ep.experimento_id=:id', array(':id'=>$id))
            ->queryAll();

            // Equipos
            $equipos = Yii::app()->db->createCommand()
            ->select('e.id, e.nombre, e.marca, e.observaciones, e.estado')
            ->from('equipo e')
            ->join('experimento_equipo ee', 'ee.equipo_id=e.id')
            ->where('ee.experimento_id=:id', array(':id'=>$id))
            ->queryAll();

            $data = array(
                'productos' => $productos,
                'series'    => $series,
                'equipos'   => $equipos
            );

            $this->render('create/verificar_info/verificar_info',array(
                    'model'=>$model,
                    'data'=>$data,
                    'tipo'=>$tipo
            ));
	}
        
        /**
         * Función para cambiar el estado de un determinado experimento
         */
        public function actionCambiarEstado($id) 
        {
            if(Yii::app()->request->isPostRequest) {
                // Realizar el cambio de estado
                $this->_cambiar_estado_proceso();
            }
            else {
                // Mostrar el panel con la información necesaria para el cambio de estado
                $tipo = 'Experimento';
                $model = $this->loadModel($id);
                $this->add_js('js/laboratorio/experimento.js');
                
                // En caso de estado FINALIZADO, redirigir a Detalles
                if ($model->estado == 'FINALIZADO') {
                    $this->redirect(array('view','id'=>$model->id));
                }
                
                // Mensaje a mostrar en la confirmación del cambio de estado
                $mensaje = '';
                $opcion_cambiar_estado = true;
                switch ($model->estado) {
                    case 'INICIADO':
                        // Obtener la cantidad de productos y equipos asociados
                        
                        // Productos
                        $productos = Yii::app()->db->createCommand()
                        ->select('p.id')
                        ->from('producto p')
                        ->join('experimento_producto ep', 'ep.producto_id=p.id')
                        ->where('ep.experimento_id=:id', array(':id'=>$id))
                        ->queryAll();

                        // Equipos
                        $equipos = Yii::app()->db->createCommand()
                        ->select('e.id')
                        ->from('equipo e')
                        ->join('experimento_equipo ee', 'ee.equipo_id=e.id')
                        ->where('ee.experimento_id=:id', array(':id'=>$id))
                        ->queryAll();
                        
                        $opcion_cambiar_estado = false;
                        if (count($productos) > 0 and count($equipos) > 0) {
                            $opcion_cambiar_estado = true;
                        }
                        
                        $mensaje = '
                        <strong>Al cambiar de estado, el experimento pasará a estado "Preparado".</strong>
                        <br ><br />
                        Este cambio significa que los productos y las series cargadas dejarán de estar disponibles para la utilización de los demás experimentos.
                        <br ><br />
                        ¿Seguro que desea cambiar de estado?';
                        break;
                    case 'PREPARADO':
                        $mensaje = '
                        <strong>Al cambiar de estado, el experimento pasará a estado "En curso".</strong>
                        <br ><br />
                        Este cambio significa que los productos ya se han utilizado y esta todo listo para tomar medidas experimentales y analizar los resultados obtenidos.
                        <br ><br />
                        ¿Seguro que desea cambiar de estado?';
                        break;
                    case 'EN_CURSO':
                        $mensaje = '
                        <strong>Al cambiar de estado, el experimento pasará a estado "Finalizado".</strong>
                        <br ><br />
                        Este cambio significa que se han terminado todas las actividades que se había planteado para el experimento.
                        <br>
                        A partir de este cambio, ya no puede realizarse ningún cambio en el experimento
                        <br ><br />
                        ¿Seguro que desea cambiar de estado?';
                        break;
                    case 'FINALIZADO':
                        $mensaje = '';
                        break;
                }
                
                $info_basica = $this->_info_basica_experimento($id);
                $data = array(
                    'info_basica'           => $info_basica,
                    'opcion_cambiar_estado' => $opcion_cambiar_estado,
                    'mensaje'               => $mensaje
                );

                $this->render('estado/estado',array(
                        'model'=>$model,
                        'data'=>$data,
                        'tipo'=>$tipo
                ));
            }
        }
        
        /**
         * Función para realizar el cambio de estado de un experimento
         */
        private function _cambiar_estado_proceso() 
        {
            // Obtener el ID del experimento proveniente del POST
            $id = $_POST['experimento_id'];

            $command = Yii::app()->db->createCommand();

            // 1) Obtener el estado del experimento
            $experimento = $command->select('estado')
            ->from('experimento')
            ->where('id=:id', array(':id'=>$id))
            ->queryRow();

            if ($experimento) {
                // 2) Dependiendo del estado, se pasa al estado siguiente
                $nuevo_estado = '';
                switch ($experimento['estado']) {
                    case 'INICIADO':    $nuevo_estado = 'PREPARADO';    break;
                    case 'PREPARADO':   $nuevo_estado = 'EN_CURSO';    break;
                    case 'EN_CURSO':    $nuevo_estado = 'FINALIZADO';    break;
                    case 'FINALIZADO': break;
                }

                if ($nuevo_estado != '') {
                    // 3) Actualizar el estado en la tabla experimento
                    $command->reset();
                    $command->update('experimento', array(
                        'estado' => $nuevo_estado
                    ), 'id=:id', array(':id'=>$id));

                    // 4) LOG del sistema
                    $info_adicional = 'estado<<<'.$experimento['estado'].';;;estado>>>'.$nuevo_estado;
                    $relacion = 'experimento'.$id.';';
                    $log_params = array(
                        'accion'    => 'MODIFICACION',
                        'tabla'     => 'experimento',
                        'id'        => $id,
                        'relacion'  => $relacion,
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);

                    if ($nuevo_estado == 'PREPARADO') {
                        // 5) Consumir los productos asociados del stock
                        $this->_consumir_productos_del_stock($id);
                    }
                }
            }
        }
        
        /**
         * Función para consumir del stock la cantidad de productos asociados al experimento
         * @param type $id_experimento
         */
        private function _consumir_productos_del_stock($id_experimento = 0) 
        {
            if ($id_experimento > 0) {
                $command = Yii::app()->db->createCommand();
                
                // 1) Obtener los productos asociados al experimento
                $productos = $command->select('p.id, ep.producto_usa_serie, ep.cantidad')
                ->from('producto p')
                ->join('experimento_producto ep', 'ep.producto_id=p.id')
                ->where('ep.experimento_id=:id', array(':id'=>$id_experimento))
                ->queryAll();
                
                if (count($productos) > 0) {
                    // 2) Generar la condición para obtener los productos del stock
                    $condicion = '';
                    foreach ($productos as $key => $p) {
                        $p = (object) $p;
                        if ($key == 0) $condicion = '(';
                        else $condicion .= ', ';
                        $condicion .= $p->id; 
                    }
                    if ($condicion != '') { 
                        $condicion .= ')';
                    
                        // 3) Obtener los productos asociados al experimento en el stock
                        $command->reset();
                        $stock_productos_db = $command->select('id, cantidad, producto_id')
                        ->from('stock')
                        ->where('producto_id IN '.$condicion)
                        ->queryAll();
                        
                        $stock_productos = array();
                        foreach ($stock_productos_db as $sp) {
                            $sp = (object) $sp;
                            $stock_productos[$sp->producto_id] = $sp;
                        }

                        // 4) Por cada producto, quitar la cantidad consumida del stock
                        foreach ($productos as $p) {
                            $p = (object) $p;
                            $stock = $stock_productos[$p->id];
                            $cantidad = $stock->cantidad - $p->cantidad;
                            
                            if ($cantidad >= 0) {
                                $command->reset();
                                $command->update('stock', array(
                                    'cantidad'              => $cantidad,
                                    'usuario_consume_id'    => Yii::app()->user->id,
                                    'fecha_consume'         => date("Y-m-d H:i:s")
                                ), 'id=:id', array(':id'=>$stock->id));

                                // LOG del sistema
                                $info_adicional = 'cantidad<<<'.$stock->cantidad.';;;cantidad>>>'.$cantidad;
                                $relacion = 'stock'.$stock->id.';';
                                $log_params = array(
                                    'accion'    => 'MODIFICACION',
                                    'tabla'     => 'stock',
                                    'id'        => $stock->id,
                                    'relacion'  => $relacion,
                                    'info'      => $info_adicional
                                );
                                $this->log($log_params);
                            }
                        }
                    }
                }
            }
        }
        
        /* ----------------------- INFORMACIÓN ADICIONAL ----------------------- */
        
        /**
         * Función para mostrar la pantalla que permite añadir información adicional al experimento
         * @param type $id
         */
        public function actionInformacionAdicional($id)
	{
            $tipo = 'Experimento';
            $model = $this->loadModel($id);
            $this->add_js('js/laboratorio/experimento.js');
            
            // En caso de estado FINALIZADO, redirigir a Detalles
            if ($model->estado == 'FINALIZADO') {
                $this->redirect(array('view','id'=>$model->id));
            }
            
            $info_basica = $this->_info_basica_experimento($id);
            $data = array(
                'info_basica' => $info_basica
            );

            $this->render('info/info',array(
                    'model'=>$model,
                    'tipo'=>$tipo,
                    'data'=>$data
            ));
	}
        
        /**
         * Función para agregar información adicional al experimento
         */
        public function actionAgregarInformacionAdicional()
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $experimento_id = $_POST['experimento_id'];
                $mas_info       = $_POST['informacion'];

                // 3) Obtener los datos del experimento
                $command = Yii::app()->db->createCommand();
                
                $experimento = $command->select('id, estado')
                ->from('experimento')
                ->where('id=:id', array(':id'=>$experimento_id))
                ->queryRow();
                
                if ($experimento) {
                    $experimento = (object) $experimento;
                    // 4) Agregar el registro con más información a la DB
                    $experimento_estado = array(
                        'experimento_id'=> $experimento->id,
                        'estado'        => $experimento->estado,
                        'fecha'         => date("Y-m-d H:i:s"),
                        'usuario_id'    => Yii::app()->user->id,
                        'mas_info'      => $mas_info
                    );
                    $command->reset();
                    $command->insert('experimento_estado', $experimento_estado);

                    // 5) LOG del sistema
                    $info_adicional = '';
                    $info_adicional .= 'experimento_id>>>'.$experimento->id;
                    $info_adicional .= ';;;mas_info>>>'.$this->log_limpiar_texto($mas_info);
                    $info_adicional .= ';;;estado>>>'.$experimento->estado;

                    $id = $this->get_last_id('experimento');
                    $log_params = array(
                        'accion'    => 'ALTA',
                        'tabla'     => 'experimento_estado',
                        'id'        => $this->get_last_id('experimento_estado'),
                        'relacion'  => 'experimento'.$experimento->id.';',
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);
                }
            }
        }
        
        /**
         * Mostrar la información por pantalla en el formulario para editar la información adicional
         */
        public function actionEditarInformacionAdicionalForm() 
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $estado_id       = $_POST['estado_id'];

                // 3) Obtener los datos del estado
                $command = Yii::app()->db->createCommand();
                
                $estado = $command->select('mas_info')
                ->from('experimento_estado')
                ->where('id=:id', array(':id'=>$estado_id))
                ->queryRow();
                
                if ($estado) {
                    // 4) Mostrar la información para editar
                    $estado = (object) $estado;
                    echo $estado->mas_info;
                }
            }
        }
        
        /**
         * Función para editar la información adicional asociada al experimento
         */
        public function actionEditarInformacionAdicional()
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $estado_id = $_POST['estado_id'];
                $mas_info  = $_POST['informacion'];

                // 3) Obtener los datos del estado
                $command = Yii::app()->db->createCommand();
                
                $estado = $command->select('experimento_id, mas_info')
                ->from('experimento_estado')
                ->where('id=:id', array(':id'=>$estado_id))
                ->queryRow();
                
                if ($estado) {
                    $estado = (object) $estado;
                    
                    // 4) Verificar que se haya modificado la información
                    if ($estado->mas_info != $mas_info) {
                    
                        // 5) Editar el registro con más información en la DB
                        $command->reset();
                        $command->update('experimento_estado', array(
                            'fecha'         => date("Y-m-d H:i:s"),
                            'usuario_id'    => Yii::app()->user->id,
                            'mas_info'      => $mas_info
                        ), 'id=:id', array(':id'=>$estado_id));

                        // 6) LOG del sistema
                        $info_adicional = '';
                        $info_adicional .= 'experimento_id>>>'.$estado->experimento_id;
                        $info_adicional .= ';;;mas_info<<<'.$this->log_limpiar_texto($estado->mas_info);
                        $info_adicional .= ';;;mas_info>>>'.$this->log_limpiar_texto($mas_info);

                        $log_params = array(
                            'accion'    => 'MODIFICACION',
                            'tabla'     => 'experimento_estado',
                            'id'        => $estado_id,
                            'relacion'  => 'experimento'.$estado->experimento_id.';',
                            'info'      => $info_adicional
                        );
                        $this->log($log_params);
                    }
                }
            }
        }
        
        /**
         * Función para mostrar el listado de información adicional asociada al experimento
         */
        public function actionListadoInformacionAdicional() 
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                
                // 2) Obtener los datos del POST
                $experimento_id = $_POST['experimento_id'];

                // 3) Obtener toda la información adicional asociada al experimento
                $command = Yii::app()->db->createCommand();
                $info_adicional = $command->select('ee.*, u.nombre, e.estado as estado_experimento')
                ->from('experimento_estado ee')
                ->join('usuario u', 'u.id=ee.usuario_id')
                ->join('experimento e', 'e.id=ee.experimento_id')
                ->where('ee.experimento_id=:id', array(':id'=>$experimento_id))
                ->order('id asc')
                ->queryAll();

                if (count($info_adicional) > 0) {
                    // 4) Dar formato a la información para el listado
                    foreach ($info_adicional as $key => $info) {
                        $info_adicional[$key]['fecha_txt'] = $this->fecha_formato_listado($info['fecha']);
                        $info_adicional[$key]['mas_info'] = $this->log_limpiar_texto($info['mas_info']);
                        $info_adicional[$key]['estado_txt'] = $this->estado_experimento_txt($info['estado']);
                    }
                }
                
                // 5) Mostrar el listado por pantalla
                $data['info_adicional'] = $info_adicional;
                $this->renderPartial('info/_listado_info_adicional', array('data' => $data));
            }
        }
        
        /**
         * Función para eliminar información adicional del experimento
         */
        public function actionEliminarInformacionAdicional()
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $estado_id = $_POST['estado_id'];

                // 3) Obtener los datos del estado
                $command = Yii::app()->db->createCommand();
                
                $estado = $command->select('experimento_id, mas_info, estado')
                ->from('experimento_estado')
                ->where('id=:id', array(':id'=>$estado_id))
                ->queryRow();
                
                if ($estado) {
                    $estado = (object) $estado;
                    
                    // 4) Eliminar el registro con información de la DB
                    $command->reset();
                    $command->delete('experimento_estado', 'id=:id', array(':id'=>$estado_id));

                    // 5) LOG del sistema
                    $info_adicional = '';
                    $info_adicional .= 'experimento_id>>>'.$estado->experimento_id;
                    $info_adicional .= ';;;mas_info>>>'.$this->log_limpiar_texto($estado->mas_info);
                    $info_adicional .= ';;;estado>>>'.$estado->estado;

                    $log_params = array(
                        'accion'    => 'BAJA',
                        'tabla'     => 'experimento_estado',
                        'id'        => NULL,
                        'relacion'  => 'experimento'.$estado->experimento_id.';',
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);
                }
            }
        }
        
        /**
         * Función para generar el widget con la información básica del experimento
         * @param type $id
         * @param type $mostrar_titulo
         * @return type
         */
        private function _info_basica_experimento($id = 0, $mostrar_titulo = true) 
        {
            $info_basica = '';
            if ($id > 0) {
                // Obtener el modelo
                $model = $this->loadModel($id);

                // Información básica
                $titulo         = ($mostrar_titulo) ? $model->titulo : '';
                $estado_txt     = $this->estado_experimento_txt($model->estado);
                $estado_icono   = $this->estado_experimento_icono($model->estado);
                $fecha_creacion = $this->fecha_formato_texto($model->fecha);
                $nombre_usuario = $this->nombre_usuario($model->usuario_id);

                // Cargar el array de datos
                $data = array(
                    'id'                => $id,
                    'titulo'            => $titulo,
                    'estado_txt'        => $estado_txt,
                    'estado_icono'      => $estado_icono,
                    'fecha_creacion'    => $fecha_creacion,
                    'nombre_usuario'    => $nombre_usuario
                );

                // Generar la vista parcial
                $info_basica = $this->renderPartial('_info_basica', array('data'=>$data), true);
            }
            return $info_basica;
        }
        
        /**
         * Función para eliminar un experimento y toda su infomración asociada
         */
        public function actionEliminarExperimento()
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                $command = Yii::app()->db->createCommand();
                
                // 2) Obtener el ID del experimento proveniente del POST
                $experimento_id = $_POST['experimento_id'];
                
                // 3) Obtener los datos del experimento
                $experimento = $command->select('titulo, estado')
                    ->from('experimento')
                    ->where('id=:id', array(':id'=>$experimento_id))
                    ->queryRow();
                
                if ($experimento['estado'] == 'INICIADO') {
                    
                    // 4) Obtener el consumo asociado al experimento
                    $command->reset();
                    $consumo = $command->select('id')
                    ->from('consumo')
                    ->where('experimento_id=:id', array(':id'=>$experimento_id))
                    ->queryRow();
                    
                    if ($consumo) {
                        $consumo_id = $consumo['id']; 
                        
                        // 5) Obtener todos los renglones de consumo
                        $command->reset();
                        $renglones_consumo = $command->select('id')
                        ->from('renglon_consumo')
                        ->where('consumo_id=:id', array(':id'=>$consumo_id))
                        ->queryAll();
                        
                        if (count($renglones_consumo) > 0) {
                            // 6) Recorrer los renglones de consumo para quitar las series asignadas
                            foreach ($renglones_consumo as $rc) {
                                $renglon_consumo_id = $rc['id'];
                                
                                $command->reset();
                                $command->update('serie', array(
                                    'renglon_consumo_id' => NULL
                                ), 'renglon_consumo_id=:id', array(':id'=>$renglon_consumo_id));
                            }
                        }

                        // 7) Eliminar todos los renglones de consumo
                        $command->reset();
                        $command->delete('renglon_consumo', 
                            'consumo_id='.$consumo_id
                        );

                        // 8) Eliminar el consumo del experimento
                        $command->reset();
                        $command->delete('consumo', 
                            'id='.$consumo_id
                        );
                    }

                    // 9) Eliminar todos los productos asociados
                    $command->reset();
                    $command->delete('experimento_producto', 
                        'experimento_id='.$experimento_id
                    );

                    // 10) Eliminar todos los equipos asociados
                    $command->reset();
                    $command->delete('experimento_equipo', 
                        'experimento_id='.$experimento_id
                    );
                    
                    // 11) Eliminar todas las series asociadas
                    $command->reset();
                    $command->delete('experimento_serie', 
                        'experimento_id='.$experimento_id
                    );

                    // 12) Eliminar toda la información adicional
                    $command->reset();
                    $command->delete('experimento_estado', 
                        'experimento_id='.$experimento_id
                    );

                    // 13) Eliminar todos los logs
                    $command->reset();
                    $command->delete('log', 
                        'relacion LIKE \'%experimento'.$experimento_id.';%\''
                    );

                    // 14) Eliminar el experimento
                    $command->reset();
                    $command->delete('experimento', 
                        'id='.$experimento_id
                    );
                }
            }
        }
        
        public function actionExcelTest() {
            
            ini_set('max_execution_time', 300); 
            
            $command = Yii::app()->db->createCommand();
            

            $total_compra = 0;
            for ($i = 132; $i <= 171; $i++) {
                
                $precio = rand(10, 50);
                $total = $precio * 30;
                $total_compra += $total;
                
                $renglon = array();
                $renglon = array(
                    'cantidad' => 30,
                    'precio' => $precio,
                    'total' => $total,
                    'compra_id' => 2,
                    'producto_id' => $i,
                    'estado' => 1
                );

                // Producto a insertar en DB
                $command->reset();
                $command->insert('renglon_compra', $renglon);
            }
            
            echo 'Total compra: '.$total_compra;
            /*
            require_once 'Excel/reader.php';
            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding('CP1251');
            $data->read('fichero3.xls');
            
            echo("<table>");
            for ($i = 1; $i <= 3; $i++) {
                    echo("<tr>");
                    for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                        if (isset($data->sheets[0]['cells'][$i][$j]))
                            echo("<td>".$data->sheets[0]['cells'][$i][$j] ."</td>");
                        else
                            echo "<td></td>";
                    }
                    echo("</tr>");

            }
            echo("</table>");
            

            
            
            
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                $producto = array();
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    if (isset($data->sheets[0]['cells'][$i][$j]))
                        $valor = $data->sheets[0]['cells'][$i][$j];
                    else
                        $valor = '';
                    switch ($j) {
                        case 1: $producto['nombre'] = ($valor != '') ? utf8_encode($valor) : ''; break;
                        case 2: $producto['CAS'] = ($valor != '') ? $valor : NULL; break;
                        case 3: $producto['nombre'] .= ($valor != '') ? ' - Et(30): '.$valor : ''; break;
                    }
                }
                
                if ($producto['nombre'] != '') {
                    
                    $producto['descripcion'] = $producto['nombre'];
                    $producto['usa_serie'] = 1;
                    $producto['estado'] = 1;
                    $producto['tipo_producto_id'] = 2;
                    $producto['contenedor_id'] = 11;
                    
                    print_r(var_dump($producto));
                    
                    // Producto a insertar en DB
                    $command->reset();
                    $command->insert('producto', $producto);

                }
            } // FIN FOR
             * 
             */
        }
        
        /**
         * Función para realizar la búsqueda avanzada y mostrar el listado de experimentos
         */
        public function actionBusquedaAvanzada() 
        {
            if(Yii::app()->request->isPostRequest) {
                // Obtener los valores del POST
                $titulo         = strip_tags($_POST['titulo']);
                $creacion_desde = strip_tags($_POST['creacion_desde']);
                $creacion_hasta = strip_tags($_POST['creacion_hasta']);
                $estado         = strip_tags($_POST['estado']);
                $usuario_id     = strip_tags($_POST['usuario']);
                $productos      = strip_tags($_POST['productos']);
                $equipos        = strip_tags($_POST['equipos']);
                
                $command = Yii::app()->db->createCommand();
                $data = array('advanced_search'=>true);

                // Título
                if (strlen(trim($titulo)) > 0) {
                    $command->andWhere(array('like', 'e.titulo', '%'.$titulo.'%'));
                }
                // Estado
                if (strlen(trim($estado)) > 0) {
                    $command->andWhere(array('like', 'e.estado', '%'.$estado.'%'));
                }
                // Usuario
                if (strlen(trim($usuario_id)) > 0) {
                    $command->andWhere('e.usuario_id=:id', array(':id'=>$usuario_id));
                }
                
                // Fecha de creación
                $time_created_on = 0;
                if (strlen(trim($creacion_desde)) > 0) { // Desde
                    $time_created_on = strtotime($creacion_desde);
                    $command->andWhere('e.fecha >= \''.$creacion_desde.'\'');
                }
                if (strlen(trim($creacion_hasta)) > 0) { // Hasta
                    $creacion_hasta .= ' 23:59:59';
                    if ($time_created_on > strtotime($creacion_hasta)) {
                        $data['from_greater_than_to'] = true;
                    }
                    else {
                        $command->andWhere('e.fecha <= \''.$creacion_hasta.'\'');
                    }
                }
                
                // Productos
                $producto = '';
                if (strlen(trim($productos)) > 0) {
                    $data['productos'] = true;
                    $producto = ', p.nombre as producto';
                    // Añadir los JOINS para productos
                    $command->leftJoin('experimento_producto ep', 'e.id=ep.experimento_id');
                    $command->leftJoin('producto p', 'ep.producto_id=p.id');
                            
                    $sql_productos = '`p`.`nombre` LIKE \'%'.$productos.'%\' OR `p`.`descripcion` LIKE \'%'.$productos.'%\' OR `p`.`nombre_ingles` LIKE \'%'.$productos.'%\' OR `p`.`IUPAC` LIKE \'%'.$productos.'%\'';
                    $command->andWhere($sql_productos);
                }
                
                // Equipos
                $equipo = '';
                if (strlen(trim($equipos)) > 0) {
                    $data['equipos'] = true;
                    $equipo = ', eq.nombre as equipo, eq.observaciones as equipo_obs';
                    // Añadir los JOINS para equipos
                    $command->leftJoin('experimento_equipo ee', 'e.id=ee.experimento_id');
                    $command->leftJoin('equipo eq', 'ee.equipo_id=eq.id');
                    
                    $sql_equipos = '`eq`.`nombre` LIKE \'%'.$equipos.'%\' OR `eq`.`marca` LIKE \'%'.$equipos.'%\' OR `eq`.`modelo` LIKE \'%'.$equipos.'%\' OR `eq`.`observaciones` LIKE \'%'.$equipos.'%\'';
                    $command->andWhere($sql_equipos);
                }
                
                // Realizar la búsqueda en DB
                $command->select('e.id, e.usuario_id, e.fecha, e.titulo, e.estado, u.nombre as usuario'.$producto.$equipo)
                ->from('experimento e')
                ->join('usuario u', 'e.usuario_id=u.id')
                ->group('e.id');

                $experimentos = $command->queryAll();
                // Para depuración
                // print_r(var_dump($command));
                //print_r(var_dump($experimentos));
                //print_r(var_dump($data));
                
                foreach ($experimentos as $key => $e) {
                    $e = (object) $e;
                    $usuario = (object) null;
                    $usuario->nombre = $e->usuario;
                    $e->usuario = $usuario;
                    $experimentos[$key] = $e;
                }
                
                $this->renderPartial('admin/_listado',array(
                    'experimentos'=>$experimentos,
                    'data'=>$data
                ));
            }
        }
}