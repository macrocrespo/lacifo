<?php

class SiteController extends Controller
{
        public $cod_menu = 'inicio';
        
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
                    array('allow',  // allow all users to perform 'index' and 'view' actions
                            'actions'=> array('index'),
                            'users'=>array('@'),
                    ),
                    array('deny',  // allow all users to perform 'index' and 'view' actions
                            'actions'=> array('index'),
                            'users'=>array('*'),
                    ),
		);
	}
        
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        /* --------------------------------- INICIO --------------------------------- */

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            $this->add_js('js/laboratorio/index.js');
            
            // Obtener la cantidad de notificaciones
            $command = Yii::app()->db->createCommand();
            $stock = $command->select('s.id')
            ->from('stock s')
            ->where('s.cantidad < s.minimo')
            ->queryAll();
            
            $data = array();
            $data['problemas_stock'] = (count($stock) > 0) ? true : false;
            $this->render('inicio/index', array('data' => $data));
	}
        
        /**
         * Función para mostrar la lista de items asociados al usuario en el panel de perfil
         */
        public function actionListaPerfilUsuario() 
        {
            $command = Yii::app()->db->createCommand();
            
            // Obtener las tareas asociadas al usuario
            $tareas = $command->select('id')
            ->from('tarea')
            ->where('usuario_id=:id', array(':id'=>Yii::app()->user->id))
            ->queryAll();
            
            // Obtener la cantidad de experimentos en curso
            $command->reset();
            $experimentos = $command->select('id')
            ->from('experimento')
            ->where('estado<>\'FINALIZADO\'')
            ->queryAll();
            
            // Obtener la cantidad de notificaciones
            $command->reset();
            $notificaciones = $command->select('s.id')
            ->from('stock s')
            ->where('s.cantidad < s.sugerido')
            ->order('s.cantidad asc')
            ->queryAll();
            
            /*
            // Obtener la cantidad de productos
            $command->reset();
            $productos = $command->select('id')
            ->from('producto')
            ->where('estado=1')
            ->queryAll();
            
            // Obtener la cantidad de compras
            $command->reset();
            $compras = $command->select('id')
            ->from('compra')
            ->where('estado=1')
            ->queryAll();
             * 
             */
            
            $data = array(
                'cant_tareas' => count($tareas),
                'cant_experimentos' => count($experimentos),
                'cant_notificaciones' => count($notificaciones)
                /*
                'cant_productos' => count($productos),
                'cant_compras' => count($compras)
                 * 
                 */
            );
            
            $this->renderPartial('inicio/_lista_perfil_usuario', array('data' => $data));
        }

        public function actionActividadLaboratorio() 
        {
            // 1) Obtener los logs importantes que deben figurar en la actividad del laboratorio
            $command = Yii::app()->db->createCommand();
            $logs = $command->select('*')
            ->from('log')
            ->orWhere('tabla=\'experimento\'')
            ->orWhere('tabla=\'experimento_estado\'')
            ->orWhere('tabla=\'tarea\'')
            ->order('fecha desc')
            ->limit(5)
            ->queryAll();
            
            // Dar formato a los logs asociados al experimento
            $logs = $this->obtener_formato_logs($logs);
            
            // Obtener los iconos de cada tipo de información
            foreach ($logs as $key => $log) {
                switch ($log->tabla) {
                    case 'experimento': 
                        $logs[$key]->tipo_icono = 'icon-lightbulb';
                        $logs[$key]->tooltip = 'experimento';
                        break;
                    case 'experimento_estado':
                        $logs[$key]->tipo_icono = 'icon-lightbulb';
                        $logs[$key]->tooltip = 'información adicional';
                        break;
                    case 'tarea': 
                        $logs[$key]->tipo_icono = 'icon-check'; 
                        $logs[$key]->tooltip = 'tabla';
                        break;
                }
                
                if ($log->accion == 'MODIFICACION') {
                    $logs[$key]->descripcion .= '<br>'.$log->informacion;
                }
            }
            
            $data = array('logs'=>$logs);
            $this->renderPartial('inicio/_actividad_laboratorio', array('data' => $data));
        }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
                $this->layout='//layouts/vacio';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}