<?php

class RubroController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Rubros';
        public $contenido       = 'rubro';
        public $controller      = 'rubro';
        public $cod_menu        = 'productos/rubro';

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
                $command->select('p.id, p.nombre, p.descripcion, p.marca, p.tipo_producto_id, tp.nombre as tipo_producto_nombre')
                ->from('producto p')
                ->join('tipo_producto tp', 'tp.id=p.tipo_producto_id')
                ->join('rubro r', 'r.id=tp.rubro_id')
                ->andWhere('r.id=:id', array(':id'=>$id))
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
		$model=new Rubro;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rubro']))
		{
			$model->attributes=$_POST['Rubro'];
			if($model->save()) {
                            // Log de la creación
                            $this->log_create('Rubro', 'rubro', $model->id);
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

		if(isset($_POST['Rubro']))
		{
                        // LOG de la edición
                        $this->log_update('Rubro', 'rubro', $model);

			$model->attributes=$_POST['Rubro'];
			if($model->save()) {                            
                            $this->redirect(array('view','id'=>$model->id));
                        }
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
                            'relacion LIKE \'%rubro'.$id.';%\''
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
         * Función para validar si un rubro puede eliminarse
         * @param type $id
         */
        public function validarEliminacion($id)
        {
            // Un rubro puede eliminarse si no tiene tipos de productos asociados
            $command = Yii::app()->db->createCommand();
            $command->select('r.id')
            ->from('rubro r')
            ->join('tipo_producto tp', 'tp.rubro_id=r.id')
            ->andWhere('r.id=:id', array(':id'=>$id));
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
                $model=Rubro::model()->findAll();
		$this->render('admin',array(
			'model'=>$model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Rubro::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='rubro-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
