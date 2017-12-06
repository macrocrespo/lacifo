<?php

class ProductoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Productos';
        public $contenido       = 'producto';
        public $controller      = 'producto';
        public $cod_menu        = 'productos/producto';

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
            $this->add_js('js/laboratorio/producto.js');
            
            $model = $this->loadModel($id);
            $model->rubro = $this->get_rubro_by_tipo_producto($model->tipo_producto_id);
            $model->deposito = $this->get_deposito_by_contenedor($model->contenedor_id);
            $rubro = Rubro::model()->findByPk($model->rubro);
            $deposito = Deposito::model()->findByPk($model->deposito);

            $producto_detalle =  ProductoDetalle::model()->find('producto_id = '.$id);
            $stock = Stock::model()->find('producto_id = '.$id);

            $stock_data = (object) null;
            $stock_data->color = 'green';
            $stock_data->warning = false;
            $stock_data->error = false;
            if ($stock->cantidad < $stock->sugerido) {
                $stock_data->color = 'yellow';
                $stock_data->warning = true;
            }
            if ($stock->cantidad < $stock->minimo) {
                $stock_data->color = 'red';
                $stock_data->warning = false;
                $stock_data->error = true;
            }
            if ($stock->cantidad == 0) {
                $stock_data->color = 'red';
                $stock_data->warning = false;
                $stock_data->error = true;
            }

            $this->render('view',array(
                    'model'=>$model,
                    'rubro'=>$rubro,
                    'deposito'=>$deposito,
                    'producto_detalle'=>$producto_detalle,
                    'stock'=>$stock,
                    'stock_data'=>$stock_data
            ));
	}
        
        /**
         * Función para mostrar el listado de experimentos asociados al producto
         */
        public function actionListadoExperimentosPorProducto() 
        {
            if(isset($_POST['producto_id'])) {
                $producto_id = $_POST['producto_id'];
                
                // Obtener todos los experimentos asociados al producto
                $command = Yii::app()->db->createCommand();
                $command->select('e.*')
                ->from('experimento e')
                ->join('experimento_producto ep', 'ep.experimento_id=e.id')
                ->andWhere('ep.producto_id=:producto_id', array(':producto_id'=>$producto_id))
                ->order('e.id desc');
                $experimentos = $command->queryAll();
                
                // Obtener los usuarios
                $usuarios = Yii::app()->db->createCommand()
                ->select('u.id, u.nombre')
                ->from('usuario u')
                ->andWhere('u.estado=1')
                //->andWhere('u.rol_id>1')
                ->order('u.nombre asc')
                ->queryAll();
                $usuarios_array = array();
                foreach ($usuarios as $u) {
                    $u = (object) $u;
                    $usuarios_array[$u->id] = $u->nombre;
                }
                
                $this->renderPartial('_listado_experimentos',array(
                    'experimentos'=>$experimentos,
                    'usuarios'=>$usuarios_array
                ));
            }
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $this->add_js('js/laboratorio/producto.js');
		$model=new Producto;
                $producto_detalle = new ProductoDetalle;
                $stock = new Stock;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Producto']))
		{
			$model->attributes=$_POST['Producto'];
			if($model->save()) {
                            if ($model->usa_detalle) {
                                if(isset($_POST['Producto'])) {
                                    // Guardar los valores de producto_detalle si se habilita la opción
                                    $producto_detalle->attributes=$_POST['ProductoDetalle'];
                                    $producto_detalle->producto_id = $model->id;
                                    $producto_detalle->save();
                                }
                            }
                            // Validar que los valores de stock sean números
                            if (!is_numeric($_POST['Stock']['minimo'])) $_POST['Stock']['minimo'] = 0;
                            if (!is_numeric($_POST['Stock']['maximo'])) $_POST['Stock']['maximo'] = 0;
                            if (!is_numeric($_POST['Stock']['sugerido'])) $_POST['Stock']['sugerido'] = 0;
                            if (!is_numeric($_POST['Stock']['cantidad'])) $_POST['Stock']['cantidad'] = 0;
                            
                            // Guardar los valores de stock
                            $stock->attributes=$_POST['Stock'];
                            $stock->usuario_ingresa_id = Yii::app()->user->id;
                            $stock->fecha_ingresa = date("Y-m-d H:i:s");
                            $stock->producto_id = $model->id;
                            $stock->save();

                            $info_adicional = '';
                            $info_adicional .= 'nombre>>>'.$this->log_limpiar_texto($model->nombre);
                            $info_adicional .= ';;;descripcion>>>'.$this->log_limpiar_texto($model->descripcion);
                            if ($model->nombre_ingles) {
                            $info_adicional .= ';;;nombre_ingles>>>'.$this->log_limpiar_texto($model->nombre_ingles);
                            }
                            $info_adicional .= ';;;marca>>>'.$this->log_limpiar_texto($model->marca);
                            $info_adicional .= ';;;IUPAC>>>'.$this->log_limpiar_texto($model->IUPAC);
                            if ($model->CAS) {
                            $info_adicional .= ';;;CAS>>>'.$this->log_limpiar_texto($model->CAS);
                            }
                            if ($producto_detalle->fraccion) {
                            $info_adicional .= ';;;fraccion>>>'.$this->log_limpiar_texto($producto_detalle->fraccion);
                            }
                            if ($producto_detalle->unidad_medida) {
                            $info_adicional .= ';;;unidad_medida>>>'.$this->log_limpiar_texto($producto_detalle->unidad_medida);
                            }
                            if ($producto_detalle->formula_quimica) {
                            $info_adicional .= ';;;formula_quimica>>>'.$this->log_limpiar_texto($producto_detalle->formula_quimica);
                            }
                            
                            // LOG del sistema
                            $id = $this->get_last_id('producto');
                            $log_params = array(
                                'accion'    => 'ALTA',
                                'tabla'     => 'producto',
                                'id'        => $id,
                                'relacion'  => 'producto'.$id.';',
                                'info'      => $info_adicional
                            );
                            $this->log($log_params);
                            
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

                $model->estado = 1;
		$this->render('create',array(
			'model'=>$model,
                        'producto_detalle'=>$producto_detalle,
                        'stock'=>$stock,
                        'tipo_producto_data'=>array(),
                        'contenedor_data'=>array(),
                        'titulo_panel' => 'Crear un nuevo producto'
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                $this->add_js('js/laboratorio/producto.js');
		$model=$this->loadModel($id);
                $producto_detalle =  ProductoDetalle::model()->find('producto_id = '.$id);
                if (!$producto_detalle) $producto_detalle = new ProductoDetalle;
                $stock = Stock::model()->find('producto_id = '.$id);
                if (!$stock) $stock = new Stock;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
                $tipo = 'Producto';
		if(isset($_POST[$tipo]))
		{
                    // 1) Verificar los cambios realizados en los campos del producto
                    $campos = array('nombre', 'descripcion', 'nombre_ingles', 'marca', 'IUPAC', 'CAS', 'estado', 'tipo_producto_id', 'contenedor_id', 'usa_serie');
                    $cambios = '';
                    foreach ($campos as $campo) {
                        if ($cambios != '') $cambios .= ';;;';
                        if ($model->$campo != $_POST[$tipo][$campo]) {
                            $cambios .= $campo.'<<<'.$this->log_limpiar_texto($model->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo][$campo]);
                        }
                    }
                    
                    if (isset($_POST['ProductoDetalle'])) {
                        $tipo_detalle = 'ProductoDetalle';
                        $campos = array('fraccion', 'unidad_medida', 'formula_quimica', 'peso_molecular', 'laboratorio');
                        foreach ($campos as $campo) {
                            if ($cambios != '') $cambios .= ';;;';
                            if ($producto_detalle->$campo != $_POST[$tipo_detalle][$campo]) {
                                $cambios .= $campo.'<<<'.$this->log_limpiar_texto($producto_detalle->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo_detalle][$campo]);
                            }
                        }
                    }
                    
                    // Validar que los valores de stock sean números
                    if (!is_numeric($_POST['Stock']['minimo'])) $_POST['Stock']['minimo'] = 0;
                    if (!is_numeric($_POST['Stock']['maximo'])) $_POST['Stock']['maximo'] = 0;
                    if (!is_numeric($_POST['Stock']['sugerido'])) $_POST['Stock']['sugerido'] = 0;
                    if (!is_numeric($_POST['Stock']['cantidad'])) $_POST['Stock']['cantidad'] = 0;
                    
                    $tipo_stock = 'Stock';
                    $campos = array('minimo', 'maximo', 'sugerido', 'cantidad');
                    foreach ($campos as $campo) {
                        if ($stock->$campo != $_POST[$tipo_stock][$campo]) {
                            if ($cambios != '') $cambios .= ';;;';
                            $cambios .= $campo.'<<<'.$this->log_limpiar_texto($stock->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo_stock][$campo]);
                        }
                    }
                    
                    if ($cambios != '') {
			$model->attributes=$_POST[$tipo];
			if($model->save()) {
                            if ($model->usa_detalle) {
                                if(isset($_POST[$tipo])) {
                                    // Guardar los valores de producto_detalle si se habilita la opción
                                    $producto_detalle->attributes=$_POST['ProductoDetalle'];
                                    $producto_detalle->producto_id = $model->id;
                                    $producto_detalle->save();
                                }
                            }
                            // Guardar los valores de stock
                            $stock->attributes=$_POST['Stock'];
                            $stock->producto_id = $model->id;
                            $stock->save();
                            
                            // LOG del sistema
                            $log_params = array(
                                'accion'    => 'MODIFICACION',
                                'tabla'     => 'producto',
                                'id'        => $model->id,
                                'relacion'  => 'producto'.$model->id.';',
                                'info'      => $cambios
                            );
                            $this->log($log_params);
                        }
                    }
                    // Redirigir a la página de detalles
                    $this->redirect(array('view','id'=>$model->id));
                        
		}
                else {
                    $model->rubro = $this->get_rubro_by_tipo_producto($model->tipo_producto_id);
                    $model->deposito = $this->get_deposito_by_contenedor($model->contenedor_id);
                    $tipo_producto_data = CHtml::listData(TipoProducto::model()->findAll('rubro_id = '.$model->rubro, array('order'=>'nombre')), 'id', 'nombre');
                    $contenedor_data = CHtml::listData(Contenedor::model()->findAll('deposito_id = '.$model->deposito, array('order'=>'nombre')), 'id', 'nombre');

                    $this->render('update',array(
                            'model'=>$model,
                            'producto_detalle'=>$producto_detalle,
                            'stock'=>$stock,
                            'tipo_producto_data'=>$tipo_producto_data,
                            'contenedor_data'=>$contenedor_data,
                            'titulo_panel' => 'Editar producto'
                    ));
                }
	}
        
        /**
         * Función para obtener el ID del rubro a partir del tipo de producto
         * @param type $tipo_producto_id
         * @return type
         */
        private function get_rubro_by_tipo_producto($tipo_producto_id = 0) {
            $rubro = 0;
            if ($tipo_producto_id > 0) {
                $tipo_producto = TipoProducto::model()->findByPk($tipo_producto_id);
                $rubro = $tipo_producto->rubro_id;
            }
            return $rubro;
        }
        
        /**
         * Función para obtener el ID del depósito a partir del contenedor
         * @param type $contenedor_id
         * @return type
         */
        private function get_deposito_by_contenedor($contenedor_id = 0) {
            $deposito = 0;
            if ($contenedor_id > 0) {
                $contenedor = Contenedor::model()->findByPk($contenedor_id);
                $deposito = $contenedor->deposito_id;
            }
            return $deposito;
        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
                    if ($this->validarEliminacion($id)) {
                        // Eliminar todos los logs
                        $command = Yii::app()->db->createCommand();
                        $command->delete('log', 
                            'relacion LIKE \'%producto'.$id.';%\''
                        );
                    
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
                    }

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
        
        /**
         * Función para eliminar un producto
         */
        public function actionEliminarProducto() 
        {
            $producto_id  = $_POST['producto_id'];
            
            if ($producto_id > 0) {
                
                if ($this->validarEliminacion($producto_id)) {
                    
                    // Eliminar todos los logs
                    $command = Yii::app()->db->createCommand();
                    $command->delete('log', 
                        'relacion LIKE \'%producto'.$producto_id.';%\''
                    );
                
                    // Eliminar el detalle del producto de la DB
                    $command->reset();
                    $command->delete('producto_detalle', 
                        'producto_id = :producto_id',
                        array(':producto_id' => $producto_id)
                    );
                    // Eliminar el producto de la DB
                    $command->reset();
                    $command->delete('producto', 
                        'id = :id',
                        array(':id' => $producto_id)
                    );
                }
            }
        }
        
        /**
         * Función para validar si un producto puede eliminarse
         * @param type $id
         */
        public function validarEliminacion($id)
        {
            // Un producto puede eliminarse si no tiene experimentos asociados
            $command = Yii::app()->db->createCommand();
            $command->select('p.id')
            ->from('producto p')
            ->join('experimento_producto ep', 'ep.producto_id=p.id')
            ->andWhere('p.id=:id', array(':id'=>$id));
            $result = $command->queryAll();
            
            $respuesta = (count($result) == 0) ? true : false;
            if(Yii::app()->request->isPostRequest)
                return $respuesta;
            else
                echo $respuesta;
        }
        
        public function actionValidarEliminacion($id)
        {
            $this->validarEliminacion($id);
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
                $this->add_js('js/laboratorio/producto.js');
                //$model=Producto::model()->findAll();
		$this->render('admin',array());
	}
        
        /**
         * Función para mostrar el listado de productos
         */
        public function actionListadoProductos() 
        {
            // Obtener todos los productos
            $command = Yii::app()->db->createCommand();
            $command->select('p.id, p.nombre, p.marca, p.descripcion, tp.nombre as tipo')
            ->from('producto p')
            ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id');
            $productos = $command->queryAll();

            $this->renderPartial('_listado',array(
                'productos'=>$productos
            ));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Producto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='producto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         * Función para mostrar el select de tipos de producto asociado
         * a un determinado rubro
         */
        public function actionSelect_tipo_producto_por_rubro() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $rubro_id = $_POST['rubro'];
                if ($rubro_id > 0) {
                    $tipos_producto = TipoProducto::model()->findAll('rubro_id = '.$rubro_id, array('order'=>'nombre'));
                    echo CHtml::dropDownList(
                            'Producto[tipo_producto_id]',
                            'Producto_tipo_producto_id', 
                            CHtml::listData($tipos_producto, 'id', 'nombre'), 
                            array('prompt'=>'Seleccionar tipo de producto...', 'class' => 'form-control')
                         );
                }
                else {
                    echo CHtml::dropDownList(
                            'Producto[tipo_producto_id]',
                            'Producto_tipo_producto_id', 
                            array(), 
                            array('prompt'=>'Seleccione un rubro primero...', 'class' => 'form-control')
                         );
                }
            }
        }
        
        /**
         * Función para mostrar el select de contenedores asociados
         * a un determinado depósito
         */
        public function actionSelect_contenedor_por_deposito() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $deposito_id = $_POST['deposito'];
                if ($deposito_id > 0) {
                    $contenedores = Contenedor::model()->findAll('deposito_id = '.$deposito_id, array('order'=>'nombre'));
                    echo CHtml::dropDownList(
                            'Producto[contenedor_id]',
                            'Producto_contenedor_id', 
                            CHtml::listData($contenedores, 'id', 'nombre'), 
                            array('prompt'=>'Seleccionar contenedor...', 'class' => 'form-control')
                         );
                }
                else {
                    echo CHtml::dropDownList(
                            'Producto[contenedor_id]',
                            'Producto_contenedor_id', 
                            array(), 
                            array('prompt'=>'Seleccione un depósito primero...', 'class' => 'form-control')
                         );
                }
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
                case 'tmp_productos_por_compra':
                    $criteria->select = array(
                        't.*',
                        'rc.cantidad as rc_cantidad',
                        'rc.precio as rc_precio',
                        'rc.total as rc_total',
                        'rc.estado as rc_estado',
                        );
                    $criteria->join = 'JOIN tmp_renglon_compra rc ON rc.producto_id = t.id';
                    $criteria->addCondition('rc.compra_id = :compra_id');
                    $criteria->params = $params;
                    break;
                case 'productos_por_compra':
                    $criteria->select = array(
                        't.*',
                        'rc.cantidad as rc_cantidad',
                        'rc.precio as rc_precio',
                        'rc.total as rc_total',
                        'rc.estado as rc_estado',
                        );
                    $criteria->join = 'JOIN renglon_compra rc ON rc.producto_id = t.id';
                    $criteria->addCondition('rc.compra_id = :compra_id');
                    $criteria->params = $params;
                    break;
                case 'productos_por_nombre':
                    $criteria->select = 't.*';
                    $criteria->addCondition('t.nombre LIKE concat(:nombre,\'%\') OR t.descripcion LIKE concat(:nombre,\'%\') OR id = :nombre');
                    $criteria->params = $params;
                    break;
            }
            return $criteria;
        }
}
