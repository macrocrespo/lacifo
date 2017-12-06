<?php

class UsuarioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Usuarios';
        public $contenido       = 'usuario';
        public $controller      = 'usuario';
        public $cod_menu        = 'config/usuario';

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
				'actions'=>array('create','update', 'index','view', 'admin', 'delete'),
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
                $model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Usuario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Usuario'])) {
                    $model->attributes = $_POST['Usuario'];
                    $model->imagen=CUploadedFile::getInstance($model,'imagen');
                    if ($model->save()) {
                        if ($model->imagen)
                            $model->imagen->saveAs(Yii::app()->basePath.'/../images/usuarios/'.strtolower($model->imagen));
                        PermisoUsuario::model()->heredar_permisos_desde_rol($model->id, $model->rol_id);
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
                
                $model->estado = 1; // Por defecto, al crear un usuario, el estado es "activo"
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

		if (isset($_POST['Usuario'])) {
                    $imagen_anterior = $model->imagen;
                    $rol_anterior = $model->rol_id;
                    $model->attributes = $_POST['Usuario'];
                    
                    $model->imagen=CUploadedFile::getInstance($model,'imagen');
                    if ($model->imagen) {
                        if ($imagen_anterior &&  file_exists('images/usuarios/'.$imagen_anterior))
                            unlink('images/usuarios/'.$imagen_anterior);
                        $model->imagen->saveAs(Yii::app()->basePath.'/../images/usuarios/'.strtolower($model->imagen));
                    }
                    else
                        $model->imagen = $imagen_anterior;
                    if ($model->save()) {
                        if ($model->rol_id != $rol_anterior)
                            PermisoUsuario::model()->reemplazar_permisos_desde_rol($model->id, $model->rol_id);
                        $this->redirect(array('view', 'id' => $model->id));
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
                        $model = $this->loadModel($id);
                        // Eliminar la imagen asociada al usuario
                        if ($model->imagen && file_exists('images/usuarios/'.$model->imagen))
                            unlink('images/usuarios/'.$model->imagen);
      
			// we only allow deletion via POST request
			$model->delete();

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
                /*
		$dataProvider=new CActiveDataProvider('Usuario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
                 * 
                 */
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                $this->layout='//layouts/listado';
                $model=Usuario::model()->findAll();
		$this->render('admin',array(
			'model'=>$model,
		));
                /*
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('admin',array(
			'model'=>$model,
		));
                 * 
                 */
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Usuario::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
