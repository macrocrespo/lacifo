<?php

class EquipoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Equipos';
        public $contenido       = 'equipo';
        public $controller      = 'equipo';
        public $cod_menu        = 'equipo';

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
            $this->layout='//layouts/listado';
            $tipo = 'Experimento';
            $model = $this->loadModel($id);
            $this->add_js('js/laboratorio/experimento.js');
            
            $info_basica = $this->_info_basica_experimento($id);
            
            // Productos
            $productos = Yii::app()->db->createCommand()
            ->select('p.id, p.nombre, tp.nombre as tipo, ep.producto_usa_serie, ep.cantidad, pd.unidad_medida')
            ->from('producto p')
            ->join('experimento_producto ep', 'ep.producto_id=p.id')
            ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
            ->leftJoin('producto_detalle pd', 'pd.producto_id=p.id')
            ->where('ep.experimento_id=:id', array(':id'=>$id))
            ->queryAll();

            // Series
            $series = Yii::app()->db->createCommand()
            ->select('es.serie, p.id, p.nombre')
            ->from('experimento_serie es')
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
                
            $this->render('view/view',array(
                    'model'=>$model,
                    'data'=>$data,
                    'tipo'=>$tipo
            ));
	}
        

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $tipo = 'Equipo';
		$model=new Experimento;
                $this->add_js('js/laboratorio/equipo.js');
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
                            
                            // Redirigir al siguiente paso
                            $this->redirect(array('agregarProductos','id'=>$model->id));
                        }
		}

		$this->render('create/create',array(
			'model'=>$model,
                        'tipo'=>$tipo
		));
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
                    
                    // 4) Dependiendo del estado del experimento, regirigir a la página correspondiente
                    if ($model->estado == 'INICIADO') {
                        // Redirigir al siguiente paso
                        $this->redirect(array('agregarProductos','id'=>$model->id));
                    }
                    else {
                        // Redirigir al panel principal
                        $this->redirect(Yii::app()->request->baseUrl.'/'.$this->controller);
                    }
                }
            }

            $this->render('update',array(
                    'model'=>$model,
                    'tipo'=>$tipo
            ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            /*
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
             * 
             */
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
                $this->add_js('js/laboratorio/equipo.js');

		$this->render('admin/admin',array());
	}
        
        /**
         * Función para mostrar el listado de equipos
         */
        public function actionListadoEquipos() 
        {
            // Obtener todos los experimentos
            $equipos = Equipo::model()->findAll();
            
            $this->renderPartial('admin/_listado',array(
                'equipos'=>$equipos
            ));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Equipo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}