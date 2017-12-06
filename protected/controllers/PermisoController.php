<?php

class PermisoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Asignar permisos';
        public $contenido       = 'permiso';
        public $controller      = 'permiso';
        public $cod_menu        = 'config/permiso';

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
         * Función para generar los criterios para consultas a DB
         * @param type $type
         * @param type $params array(':user_id'=>$id)
         * @return \CDbCriteria
         */
        private function criteria($type = '', $params = array()) {
            $criteria = new CDbCriteria;
            switch ($type) {
                case 'permisos_por_asignar':
                    // SELECT * FROM seccion WHERE seccion.id 
                    $criteria->select = 't.*';
                    $criteria->addCondition('t.id NOT IN (SELECT seccion_id FROM permiso_usuario where usuario_id = :usuario_id) and estado = 1');
                    $criteria->params = $params;
                    break;
                case 'permisos_por_asignar_rol':
                    // SELECT * FROM seccion WHERE seccion.id 
                    $criteria->select = 't.*';
                    $criteria->addCondition('t.id NOT IN (SELECT seccion_id FROM permiso_rol where rol_id = :rol_id) and estado = 1');
                    $criteria->params = $params;
                    break;
            }
            return $criteria;
        }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $this->layout='//layouts/listado';
            $this->add_js('js/laboratorio/permiso.js');
            $this->render('index');
	}
        
        public function actionListado() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tipo = $_POST['tipo'];
                if ($tipo == 1) { // Usuarios
                    $model = Usuario::model()->findAll();
                    $this->renderPartial('listado_usuarios',array(
                            'model'=>$model,
                    ));
                }
                if ($tipo == 2) { // Roles
                    $model = Rol::model()->findAll();
                    $this->renderPartial('listado_roles',array(
                            'model'=>$model,
                    ));
                }
            }
        }
        
        public function actionUsuario($id = 0) {
            $this->layout='//layouts/listado';
            if ($id > 0) {
                $this->add_js('js/laboratorio/permiso.js');
                $tipo = 'usuario';
                $usuario = Usuario::model()->findByPk($id);
                $permisos_asignados = $this->actionPermisos_asignados($tipo, $id);
                $permisos_por_asignar = $this->actionPermisos_por_asignar($tipo, $id);
                $this->render('usuario',array(
                        'usuario'=>$usuario,
                        'tipo'=>$tipo,
                        'permisos_asignados'=>$permisos_asignados,
                        'permisos_por_asignar'=>$permisos_por_asignar,
                ));
            }
            else {
                $this->redirect(Yii::app()->baseUrl.'/permiso/index');
            }
        }
        
        public function actionRol($id = 0) {
            $this->layout='//layouts/listado';
            if ($id > 0) {
                $this->add_js('js/laboratorio/permiso.js');
                $tipo = 'rol';
                $rol = Rol::model()->findByPk($id);
                $permisos_asignados = $this->actionPermisos_asignados($tipo, $id);
                $permisos_por_asignar = $this->actionPermisos_por_asignar($tipo, $id);
                $this->render('rol',array(
                        'rol'=>$rol,
                        'tipo'=>$tipo,
                        'permisos_asignados'=>$permisos_asignados,
                        'permisos_por_asignar'=>$permisos_por_asignar,
                ));
            }
            else {
                $this->redirect(Yii::app()->baseUrl.'/permiso/index');
            }
        }
        
        /**
         * Función para asignar el permiso a un usuario o rol
         */
        public function actionAsignar_permiso() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tipo       = $_POST['tipo'];
                $id         = $_POST['id'];
                $seccion_id = $_POST['seccion_id'];
                if (($tipo == 'usuario' || $tipo == 'rol') && $id > 0 && $seccion_id > 0) {
                    switch ($tipo) {
                        case 'usuario':
                            PermisoUsuario::model()->asignar_permiso_a_usuario($id, $seccion_id);
                            break;
                        case 'rol':
                            PermisoRol::model()->asignar_permiso_a_rol($id, $seccion_id);
                            break;
                    }
                }
            }
        }
        
        /**
         * Función para quitar el permiso a un usuario o rol
         */
        public function actionQuitar_permiso() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tipo       = $_POST['tipo'];
                $id         = $_POST['id'];
                if (($tipo == 'usuario' || $tipo == 'rol') && $id > 0) {
                    switch ($tipo) {
                        case 'usuario':
                            PermisoUsuario::model()->quitar_permiso_a_usuario($id);                            
                            break;
                        case 'rol':
                            PermisoRol::model()->quitar_permiso_a_rol($id);
                            break;
                    }
                }
            }
        }
        
        /**
         * Función para generar la tabla de permisos asignados
         * @param type $tipo
         * @param type $id
         * @return type
         */
        public function actionPermisos_asignados($tipo = '', $id = 0) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tipo = $_POST['tipo'];
                $id   = $_POST['id'];
            }
            $result = '';
            if ($id > 0) {
                switch ($tipo) {
                    case 'usuario':
                        $permisos_asignados = PermisoUsuario::model()->findAll('usuario_id='.$id);
                        break;
                    case 'rol':
                        $permisos_asignados = PermisoRol::model()->findAll('rol_id='.$id);
                        break;
                }
                $result = $this->renderPartial(
                        'permisos_asignados',
                        array('permisos_asignados'=>$permisos_asignados),
                        true);
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
                echo $result;
            else
                return $result;
        }
        
        /**
         * Función para generar la tabla de permisos por asignar
         * @param type $tipo
         * @param type $id
         * @return type
         */
        public function actionPermisos_por_asignar($tipo = '', $id = 0) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $tipo = $_POST['tipo'];
                $id   = $_POST['id'];
            }
            $result = '';
            if ($id > 0) {
                switch ($tipo) {
                    case 'usuario':
                        $params = array(':usuario_id'=>$id);
                        $criteria_ppa = $this->criteria('permisos_por_asignar', $params);
                        break;
                    case 'rol':
                        $params = array(':rol_id'=>$id);
                        $criteria_ppa = $this->criteria('permisos_por_asignar_rol', $params);
                        break;
                }
                $permisos_por_asignar = Seccion::model()->findAll($criteria_ppa);
                $result = $this->renderPartial(
                        'permisos_por_asignar',
                        array('permisos_por_asignar'=>$permisos_por_asignar),
                        true);
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
                echo $result;
            else
                return $result;
        }
}
