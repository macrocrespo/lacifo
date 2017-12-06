<?php

class Tipo_productoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Tipos de producto';
        public $contenido       = 'tipo de producto';
        public $controller      = 'tipo_producto';
        public $cod_menu        = 'productos/tipo_producto';

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
            $this->add_js('js/laboratorio/gestion_productos.js');
            
            $this->render('view',array(
                    'model'=>$this->loadModel($id),
            ));
	}
        
        /**
         * Función para mostrar el listado de productos
         */
        public function actionListadoProductos() 
        {
            if(isset($_POST['id'])) {
                $id = $_POST['id'];
                
                // Obtener todos productoa asociados al rubro
                $command = Yii::app()->db->createCommand();
                $command->select('p.id, p.nombre, p.descripcion, p.marca')
                ->from('producto p')
                ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
                ->andWhere('tp.id=:id', array(':id'=>$id))
                ->order('p.id asc');
                $productos = $command->queryAll();
                
                $this->renderPartial('_listado_productos',array(
                    'productos'=>$productos
                ));
            }
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TipoProducto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoProducto']))
		{
			$model->attributes=$_POST['TipoProducto'];
			if($model->save()) {
                            // Log de la creación
                            $this->log_create('TipoProducto', 'tipo_producto', $model->id);
                            // Redirigir
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

                $model->estado = 1;
		$this->render('create',array(
			'model'=>$model,
		));
	}

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

		if(isset($_POST['TipoProducto']))
		{
                        // LOG de la edición
                        $this->log_update('TipoProducto', 'tipo_producto', $model);
                        
			$model->attributes=$_POST['TipoProducto'];
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
                    if ($this->validarEliminacion($id)) {
                        // Eliminar todos los logs
                        $command = Yii::app()->db->createCommand();
                        $command->delete('log', 
                            'relacion LIKE \'%tipo_producto'.$id.';%\''
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
         * Función para validar si un tipo de producto puede eliminarse
         * @param type $id
         */
        public function validarEliminacion($id)
        {
            // Un tipo de producto puede eliminarse si no tiene productos asociados
            $command = Yii::app()->db->createCommand();
            $command->select('tp.id')
            ->from('tipo_producto tp')
            ->join('producto p', 'p.tipo_producto_id=tp.id')
            ->andWhere('tp.id=:id', array(':id'=>$id));
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
                $model=  TipoProducto::model()->findAll();
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TipoProducto::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-producto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
