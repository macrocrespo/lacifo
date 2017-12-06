<?php

class TareaController extends Controller
{
        public $layout          = '//layouts/basico';
        public $tipo_contenido  = 'Tareas';
        public $contenido       = 'tarea';
        public $controller      = 'tarea';
        public $cod_menu        = 'tarea';
        
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
        
        /**
         * Función para mostrar la pantalla principal de tareas del usuario
         * @param type $id
         */
        public function actionIndex()
	{
            $tipo = 'Tarea';
            $this->add_js('js/laboratorio/tarea.js');
            
            // Obtener los datos de los usuarios
            $usuarios = Yii::app()->db->createCommand()
            ->select('id, nombre')
            ->from('usuario')
            ->andWhere('id<>:id', array(':id'=>Yii::app()->user->id))
            ->andWhere('estado=1')
            ->andWhere('rol_id>1')
            ->order('nombre asc')
            ->queryAll();
            
            $data = array(
                'usuarios' => $usuarios
            );

            $this->render('index',array(
                    'tipo'=>$tipo,
                    'data'=>$data
            ));
	}
        
        /**
         * Función para agregar una tarea
         */
        public function actionAgregarTarea()
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                
                // 2) Obtener el ID del usuario actual
                $usuario_id = Yii::app()->user->id;
                
                // 3) Obtener los datos del POST
                $titulo         = $_POST['titulo'];
                $descripcion    = $_POST['descripcion'];
                $asignar_a      = ($_POST['asignar_a'] > 0) ? $_POST['asignar_a'] : $usuario_id;

                // 4) Agregar la tarea a la DB
                $command = Yii::app()->db->createCommand();
                    
                $tarea = array(
                    'titulo'            => $titulo,
                    'descripcion'       => $descripcion,
                    'estado'            => 1,
                    'usuario_id'        => $asignar_a,
                    'usuario_creador'   => $usuario_id,
                    'fecha'             => date("Y-m-d H:i:s"),
                );
                $command->reset();
                $command->insert('tarea', $tarea);

                // 5) LOG del sistema
                $info_adicional = '';
                $info_adicional .= 'titulo>>>'.$titulo;
                $info_adicional .= ';;;descripcion>>>'.$this->log_limpiar_texto($descripcion);
                $info_adicional .= ';;;usuario_id>>>'.$asignar_a;

                $id = $this->get_last_id('tarea');
                $log_params = array(
                    'accion'    => 'ALTA',
                    'tabla'     => 'tarea',
                    'id'        => $id,
                    'relacion'  => 'tarea'.$id.';',
                    'info'      => $info_adicional
                );
                $this->log($log_params);
            }
        }
        
        /**
         * Función para mostrar el listado de tareas asociadas a un usuario
         */
        public function actionListadoTareas() 
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                
                // 2) Obtener los datos del usuario
                $usuario_id = Yii::app()->user->id;

                // 3) Obtener las tareas relacionadas con el usuario
                $command = Yii::app()->db->createCommand();
                $tareas = $command->select('
                        t.*, 
                        u.id as usuario_asignado_id, 
                        u.nombre as usuario_asignado_nombre, 
                        u2.id as usuario_creador_id, 
                        u2.nombre as usuario_creador_nombre')
                ->from('tarea t')
                ->join('usuario u', 'u.id=t.usuario_id')
                ->join('usuario u2', 'u2.id=t.usuario_creador')
                ->orWhere('t.usuario_creador=:id', array(':id'=>$usuario_id))
                ->orWhere('t.usuario_id=:id', array(':id'=>$usuario_id))
                ->order('id asc')
                ->queryAll();
                
                // 4) Dar formato a las tareas
                if (count($tareas) > 0) {
                    foreach ($tareas as $key => $t) {
                        $tareas[$key]['fecha_txt'] = $this->fecha_formato_listado($t['fecha']);
                        $tareas[$key]['checked'] = ($t['estado']) ? '' : 'checked="checked"';
                        $tareas[$key]['class'] = ($t['estado']) ? '' : 'realizada';
                        $tareas[$key]['asignada_a'] = ($t['usuario_id'] == $usuario_id) ? 'Mi' : $t['usuario_asignado_nombre'];
                        $tareas[$key]['asignada_por'] = ($t['usuario_creador'] == $usuario_id) ? 'Mi' : $t['usuario_creador_nombre'];
                    }
                }
                
                // 5) Mostrar el listado por pantalla
                $data['tareas']   = $tareas;

                $this->renderPartial('_listado_tareas', array('data' => $data));
            }
        }
        
        /**
         * Función para obtener el título de la tarea a editar
         */
        public function actionEditarTituloTarea() 
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $tarea_id = $_POST['id'];

                // 3) Obtener los datos de la tarea
                $command = Yii::app()->db->createCommand();
                $tarea = $command->select('titulo')
                ->from('tarea')
                ->where('id=:id', array(':id'=>$tarea_id))
                ->queryRow();
                
                if ($tarea) {
                    // 4) Mostrar el título de la tarea para editar
                    echo $tarea['titulo'];
                }
            }
        }
        
        /**
         * Función para obtener la descripcion de la tarea a editar
         */
        public function actionEditarDescripcionTarea() 
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $tarea_id = $_POST['id'];

                // 3) Obtener los datos de la tarea
                $command = Yii::app()->db->createCommand();
                $tarea = $command->select('descripcion')
                ->from('tarea')
                ->where('id=:id', array(':id'=>$tarea_id))
                ->queryRow();
                
                if ($tarea) {
                    // 4) Mostrar la descripción de la tarea para editar
                    echo $tarea['descripcion'];
                }
            }
        }
        
        /**
         * Función para obtener la asignación de la tarea a editar
         */
        public function actionEditarAsignarATarea() 
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                // 2) Obtener los datos del POST
                $tarea_id = $_POST['id'];

                // 3) Obtener los datos de la tarea
                $command = Yii::app()->db->createCommand();
                $tarea = $command->select('usuario_id')
                ->from('tarea')
                ->where('id=:id', array(':id'=>$tarea_id))
                ->queryRow();
                
                if ($tarea) {
                    // 4) Mostrar la asignación de la tarea para editar
                    if (Yii::app()->user->id == $tarea['usuario_id'])
                        echo '0';
                    else
                        echo $tarea['usuario_id'];
                }
            }
        }
        
        /**
         * Función para editar una tarea
         */
        public function actionEditarTarea()
        {
            // 1) Verificar que sea una petición POST
            if(Yii::app()->request->isPostRequest) {
                
                // 2) Obtener el ID del usuario actual
                $usuario_id = Yii::app()->user->id;
                
                // 3) Obtener los datos del POST
                $id             = $_POST['tarea_id'];
                $titulo         = $_POST['titulo'];
                $descripcion    = $_POST['descripcion'];
                $asignar_a      = ($_POST['asignar_a'] > 0) ? $_POST['asignar_a'] : $usuario_id;
                
                // 4) Obtener los datos de la tarea
                $command = Yii::app()->db->createCommand();
                $tarea = $command->select('*')
                ->from('tarea')
                ->where('id=:id', array(':id'=>$id))
                ->queryRow();
                
                if ($tarea) {
                    $tarea = (object) $tarea;
                    
                    // 5) Editar la tarea a la DB
                    $command->reset();
                    $tarea_a_editar = array(
                        'titulo'            => $titulo,
                        'descripcion'       => $descripcion,
                        'usuario_id'        => $asignar_a,
                        'fecha'             => date("Y-m-d H:i:s"),
                    );
                    $command->reset();
                    $command->update('tarea', $tarea_a_editar, 
                            'id=:id', array(':id'=>$id));

                    // 6) Verificar los cambios realizados en los campos de la tarea
                    $cambios = 'titulo_tarea>>>'.$tarea->titulo;
                    $campo = 'titulo';
                    if ($tarea->$campo != $tarea_a_editar[$campo]) {
                        $campo_txt = 'Título';
                        if ($cambios != '') $cambios .= ';;;';
                        $cambios .= $campo_txt.'<<<'.$this->log_limpiar_texto($tarea->$campo).';;;'.$campo_txt.'>>>'.$this->log_limpiar_texto($tarea_a_editar[$campo]);
                    }
                    $campo = 'descripcion';
                    if ($tarea->$campo != $tarea_a_editar[$campo]) {
                        $campo_txt = 'Descripción';
                        if ($cambios != '') $cambios .= ';;;';
                        $cambios .= $campo_txt.'<<<'.$this->log_limpiar_texto($tarea->$campo).';;;'.$campo_txt.'>>>'.$this->log_limpiar_texto($tarea_a_editar[$campo]);
                    }
                    $campo = 'usuario_id';
                    if ($tarea->$campo != $tarea_a_editar[$campo]) {
                        $campo_txt = 'Asignado';
                        if ($cambios != '') $cambios .= ';;;';
                        $cambios .= $campo_txt.'<<<'.$this->nombre_usuario($tarea->$campo).';;;'.$campo_txt.'>>>'.$this->nombre_usuario($tarea_a_editar[$campo]);
                    }

                    // 7) LOG del sistema
                    $id = $this->get_last_id('tarea');
                    $log_params = array(
                        'accion'    => 'MODIFICACION',
                        'tabla'     => 'tarea',
                        'id'        => $id,
                        'relacion'  => 'tarea'.$id.';',
                        'info'      => $cambios
                    );
                    $this->log($log_params);
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
         * Función para mostrar el listado de tareas del usuario en la página de inicio
         */
        public function actionTareasUsuario() 
        {
            $command = Yii::app()->db->createCommand();
            
            // Obtener las tareas asociadas al usuario
            $tareas = $command->select('t.*, u.nombre')
            ->from('tarea t')
            ->join('usuario u', 'u.id = t.usuario_creador')
            ->where('usuario_id=:id', array(':id'=>Yii::app()->user->id))
            ->queryAll();
            
            if (count($tareas) > 0) {
                foreach ($tareas as $key => $r) {
                    $r = (object) $r;
                    $tareas[$key]['asignado_por'] = ($r->usuario_id == $r->usuario_creador) ? 'Mi' : $r->nombre;
                }
            }
            
            $data = array('tareas' => $tareas);
            $this->renderPartial('_tareas_usuario_inicio', array('data' => $data));
        }
        
        /**
         * Función para marcar la tarea como realizada
         */
        public function actionMarcarTareaRealizada()
        {
            // 1) Verificar si es una petición POST
            if (Yii::app()->request->isPostRequest) {
                
                // 2) Obtener los datos provenientes del POST
                $tarea_id = $_POST['tarea_id'];
                $estado = $_POST['estado'];
                
                // 3) Obtener los datos de la tarea
                $command = Yii::app()->db->createCommand();
                $tarea = $command->select('titulo, estado')
                ->from('tarea')
                ->where('id=:id', array(':id'=>$tarea_id))
                ->queryRow();
                
                // 4) Verificar que exista la tarea
                if ($tarea) {
                    
                    // 5) Cambiar el estado de la tarea
                    $command->reset();
                    $command->update('tarea', array(
                        'estado' => $estado
                    ), 'id=:id', array(':id'=>$tarea_id));
                    
                    // LOG del sistema
                    if ($estado)
                        $info_adicional = 'titulo_tarea>>>'.$tarea['titulo'].';;;Estado<<<Completa;;;Estado>>>Pendiente';
                    else
                        $info_adicional = 'titulo_tarea>>>'.$tarea['titulo'].';;;Estado<<<Pendiente;;;Estado>>>Completa';
                    $relacion = 'tarea'.$tarea_id.';';
                    $log_params = array(
                        'accion'    => 'MODIFICACION',
                        'tabla'     => 'tarea',
                        'id'        => $tarea_id,
                        'relacion'  => $relacion,
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);
                }
            }
        }
        
        /**
         * Función para eliminar una tarea
         */
        public function actionEliminarTarea() 
        {
            // 1) Verificar si es una petición POST
            if (Yii::app()->request->isPostRequest) {
                
                // 2) Obtener los datos provenientes del POST
                $tarea_id = $_POST['tarea_id'];
                
                // 3) Obtener los datos de la tarea
                $command = Yii::app()->db->createCommand();
                $tarea = $command->select('titulo')
                ->from('tarea')
                ->where('id=:id', array(':id'=>$tarea_id))
                ->queryRow();
                
                // 4) Verificar que exista la tarea
                if ($tarea) {
                    
                    // 5) Eliminar la tarea
                    $command->reset();
                    $command->delete('tarea', 'id='.$tarea_id);
                    
                    // LOG del sistema
                    $info_adicional = 'titulo>>>'.$tarea['titulo'];
                    $log_params = array(
                        'accion'    => 'BAJA',
                        'tabla'     => 'tarea',
                        'id'        => null,
                        'relacion'  => null,
                        'info'      => $info_adicional
                    );
                    $this->log($log_params);
                }
            }
        }
}