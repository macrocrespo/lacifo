<?php

class CompraController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Compras';
        public $contenido       = 'compra';
        public $controller      = 'compra';
        public $cod_menu        = 'stock/compra';

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
                
                $compra = $this->loadModel($id);
                
                // Obtener los prodcutos asociados a la compra
                $params = array(':compra_id'=>$id);
                $criteria_ppc = ProductoController::criteria('productos_por_compra', $params);
                $productos = Producto::model()->findAll($criteria_ppc);
            
		$this->render('view',array(
			'model'=>$compra,
                        'productos'=>$productos
		));
	}

        /* ----------------------------  INICIO COMPRA ---------------------------------- */
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TempCompra;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['TempCompra']))
		{
			$model->attributes=$_POST['TempCompra'];
                        $model->usuario_id = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('agregar_productos','id'=>$model->id));
		}
                
                $model->estado = 1;
		$this->render('create_paso_1',array(
			'model'=>$model,
		));
	}
        
        public function actionAgregar_productos($id) {
            $this->layout='//layouts/listado';
            if ($id > 0) {
                $this->add_js('js/laboratorio/compra.js');
                $model= TempCompraController::loadModel($id);
  
                $this->render('create_paso_2',array(
			'model'=>$model
		));
            }
            else
                $this->redirect(array('index'));
        }
        
        public function actionProductos_por_compra() {
            $id = $_POST['id'];
            $params = array(':compra_id'=>$id);
            $criteria_ppc = ProductoController::criteria('tmp_productos_por_compra', $params);
            $productos_por_compra = Producto::model()->findAll($criteria_ppc);
            $total = 0;
            foreach ($productos_por_compra as $ppc) {
                $total += $ppc->rc_total;
            }
            
            // Actualizar el valor de la compra temporal
            $temp_compra = TempCompra::model()->findByPk($id);
            $temp_compra->total = $total;
            $temp_compra->save();
            
            $this->renderPartial('_productos_por_compra',array(
                    'productos_por_compra' => $productos_por_compra,
                    'total' => $total
            ));
        }
        
        public function actionBuscarProductos() {
            $id = $_POST['id'];
            $params = array(':compra_id'=>$id);
            $criteria_ppc = ProductoController::criteria('tmp_productos_por_compra', $params);
            $productos_por_compra = Producto::model()->findAll($criteria_ppc);
            $ppc = '';
            foreach ($productos_por_compra as $key => $p) {
                if ($key > 0)
                    $ppc .= ',';
                $ppc .= $p->id;
            }
            
            $nombre = $_POST['nombre'];
            $params = array(':nombre'=>$nombre);
            $criteria_ppn = ProductoController::criteria('productos_por_nombre', $params);
            $productos_por_nombre = Producto::model()->findAll($criteria_ppn);
            $this->renderPartial('_busqueda_productos',array(
                'productos_por_nombre' => $productos_por_nombre,
                'productos_por_compra' => $ppc
            ));
        }
        
        public function actionAgregar_producto() {
            $renglon['producto_id'] = $_POST['idProducto'];
            $renglon['compra_id']   = $_POST['idCompra'];
            $renglon['precio']      = $_POST['costo'];
            $renglon['cantidad']    = $_POST['cantidad'];
            $renglon['total']       = $renglon['cantidad'] * $renglon['precio'];
            $renglon['estado']      = 1;
            
            TempRenglonCompra::model()->agregar($renglon);
        }
        
        public function actionEditar_producto() {
            $renglon['producto_id'] = $_POST['idProducto'];
            $renglon['compra_id']   = $_POST['idCompra'];
            $renglon['precio']      = $_POST['costo'];
            $renglon['cantidad']    = $_POST['cantidad'];
            $renglon['total']       = $renglon['cantidad'] * $renglon['precio'];
            $renglon['estado']      = 1;

            TempRenglonCompra::model()->editar($renglon);
        }
        
        public function actionEliminar_producto() {
            $renglon['producto_id'] = $_POST['idProducto'];
            $renglon['compra_id']   = $_POST['idCompra'];

            TempRenglonCompra::model()->eliminar($renglon);
        }
        
        public function actionConfirmar($id) {
            // Obtener los datos de la compra temporal
            $temp_compra = TempCompraController::loadModel($id);
            
            // Obtener los productos por compra
            $params = array(':compra_id'=>$id);
            $criteria_ppc = ProductoController::criteria('tmp_productos_por_compra', $params);
            $productos_por_compra = Producto::model()->findAll($criteria_ppc);
            $total = 0;
            foreach ($productos_por_compra as $ppc) {
                $total += $ppc->rc_total;
            }
            
            // Guardar la compra real
            $new_compra = new Compra;
            $new_compra->fecha = $temp_compra->fecha;
            $new_compra->total = $total;
            $new_compra->observacion = $temp_compra->observacion;
            $new_compra->usuario_id = $temp_compra->usuario_id;
            $new_compra->proveedor_id = $temp_compra->proveedor_id;
            $new_compra->estado = $temp_compra->estado;

            if($new_compra->save()) {
                $idCompra = $new_compra->id;
                
                // Guardar las relaciones con los productos
                foreach ($productos_por_compra as $ppc) {
                    $new_rc = new RenglonCompra;
                    $new_rc->cantidad = $ppc->rc_cantidad;
                    $new_rc->precio  = $ppc->rc_precio;
                    $new_rc->total  = $ppc->rc_total;
                    $new_rc->estado = $ppc->rc_estado;
                    $new_rc->compra_id = $idCompra;
                    $new_rc->producto_id = $ppc->id;
                    if ($new_rc->save()) {
                        // Guardar las series asociadas a cada producto
                        $condition = 'producto_id = '.$ppc->id.' AND compra_id = '.$idCompra.' ORDER BY id ASC';
                        $series = TempSeriesCompra::model()->findAll($condition);
                        foreach ($series as $serie) {
                            $new_serie = new Serie;
                            $new_serie->serie = $serie->serie;
                            $new_serie->producto_id = $serie->producto_id;
                            $new_serie->renglon_compra_id = $serie->compra_id;
                            if ($new_serie->save()) {
                                TempSeriesCompra::model()->deleteByPk($serie->id);
                            }
                        }
                        
                        // Eliminar cada renglon temporal
                        $renglon['producto_id'] = $ppc->id;
                        $renglon['compra_id']   = $id;
                        TempRenglonCompra::model()->eliminar($renglon);
                    }
                }
                
                // Eliminar la compra temporal
                TempCompra::model()->eliminar($id);
                
                $this->redirect(array('compra/view/'.$idCompra));
            }
        }
        
        public function actionAnular($id) {
            // Obtener los productos por compra
            $params = array(':compra_id'=>$id);
            $criteria_ppc = ProductoController::criteria('tmp_productos_por_compra', $params);
            $productos_por_compra = Producto::model()->findAll($criteria_ppc);

            foreach ($productos_por_compra as $ppc) {
                // Eliminar cada renglon temporal
                $renglon['producto_id'] = $ppc->id;
                $renglon['compra_id']   = $id;
                TempRenglonCompra::model()->eliminar($renglon);
            }

            // Eliminar la compra temporal
            TempCompra::model()->eliminar($id);

            $this->redirect(array('admin'));
        }
        
        public function actionCargar_tabla_series() {
            $idProducto = $_POST['idProducto'];
            $idCompra   = $_POST['idCompra'];
            $cantidad   = $_POST['cantidad'];
            $condition = 'producto_id = '.$idProducto.' AND compra_id = '.$idCompra.' ORDER BY id ASC';
            $series = TempSeriesCompra::model()->findAll($condition);
            for ($i = 1; $i <= $cantidad; $i++) {
                $array_series[$i] = '';
            }
            if (!empty($series)) {
                $i = 1;
                foreach ($series as $serie) {
                    $array_series[$i] = $serie->serie;
                    $i++;
                }
            }
            for ($i = 1; $i <= $cantidad; $i++) {
                echo ''
                . '<tr>'
                . '<th>Producto '.$i.'</th>'
                . '<td><input value="'.$array_series[$i].'" type="text" class="form-control" id="serie'.$i.'" /></td>'
                . '</tr>';
            }
        }
        
        public function actionCargar_series() {
            $idProducto = $_POST['idProducto'];
            $idCompra   = $_POST['idCompra'];
            $series     = $_POST['series'];
            
            $condition = 'producto_id = '.$idProducto.' AND compra_id = '.$idCompra.' ORDER BY id ASC';
            $series_db = TempSeriesCompra::model()->findAll($condition);
            $create = (empty($series_db)) ? true : false;
            
            $series_id = array();
            if (!empty($series_db)) {
                foreach ($series_db as $serie_db) {
                    $series_id[] = $serie_db->id;
                }
            }
            
            $i = 0;
            foreach ($series as $serie) {
                if ($create)
                    $model = new TempSeriesCompra;
                else
                    $model = TempSeriesCompra::model()->findByPk($series_id[$i]);
                $model->usuario_id  = Yii::app()->user->id;
                $model->producto_id = $idProducto;
                $model->compra_id   = $idCompra;
                $model->serie       = $serie;
                $model->fecha       = date("Y-m-d H:i:s");
                $model->save();
                $i++;
            }
        }
        
        /* ----------------------------  FIN COMPRA ---------------------------------- */

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Compra']))
		{
			$model->attributes=$_POST['Compra'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
                $model=  Compra::model()->findAll();
                $temp_compras = TempCompra::model()->findAll();
		$this->render('admin',array(
			'model'=>$model,
                        'temp_compras'=>$temp_compras
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Compra::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='compra-form')
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
        private function criteria($type = '', $params = array()) {
            $criteria = new CDbCriteria;
            switch ($type) {
            }
            return $criteria;
        }
}
