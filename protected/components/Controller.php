<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/basico';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        /**
         * Función para cargar el LOG en el sistema
         * @param type $params
         */
        public function log($params = array()) 
        {
            $accion     = (isset($params['accion']))    ? $params['accion']     : NULL;
            $tabla      = (isset($params['tabla']))     ? $params['tabla']      : NULL;
            $id         = (isset($params['id']))        ? $params['id']         : NULL;
            $relacion   = (isset($params['relacion']))  ? $params['relacion']   : NULL;
            $info       = (isset($params['info']))      ? $params['info']       : NULL;
            $fecha      = (isset($params['fecha']))     ? $params['fecha']      : NULL;
            $usuario_id = (isset($params['usuario']))   ? $params['usuario']    : NULL;
            
            $acciones = array('ALTA', 'BAJA', 'MODIFICACION', 'INGRESO', 'SALIDA');
            if ((in_array($accion, $acciones)) && strlen(trim($tabla)) > 0) {
            
                // Obtener el ID del usuario
                if ($usuario_id == 0)
                    $usuario_id = Yii::app()->user->id;
                
                // Fecha actual
                if (strlen(trim($fecha)) == 0)
                    $fecha = date("Y-m-d H:i:s");
            
                // Insertar el LOG en la DB
                $log = array(
                    'accion'        => $accion,
                    'tabla'         => $tabla,
                    'id_asociado'   => $id,
                    'relacion'      => $relacion,
                    'info_adicional'=> $info,
                    'fecha'         => $fecha,
                    'usuario_id'    => $usuario_id
                );
                $command = Yii::app()->db->createCommand();
                $command->insert('log', $log);
            }
        }
        
        /**
         * Función para obtener el último ID de una determinada tabla de la DB
         * @param type $tabla
         * @return type
         */
        public function get_last_id($tabla = '') 
        {
            // Obtener el último precio pagado por el producto en un renglón de compra
            $row = Yii::app()->db->createCommand(array(
                'select'    => array('id'),
                'from'      => $tabla,
                'limit'     => 1,
                'order'     => 'id desc'
            ))->queryRow();
            return $row['id'];
        }
        
        /**
         * Función para añadir un JS
         * @param type $js
         */
        public function add_js($js = '') 
        {
            if ($js != '') {
                $theme_url = Yii::app()->theme->baseUrl.'/';
                $cs = Yii::app()->getClientScript();
                $cs->registerScriptFile($theme_url.$js,CClientScript::POS_END);
            }
        }
        
        /**
         * Convierte la fecha "2017-01-01" en "1 de Enero de 2017"
         * @param type $fecha
         */
        public function fecha_formato_texto($fecha = '') 
        {
            $date = new DateTime($fecha);
            
            $mes = '';
            switch ($date->format('m')) {
                case '01': $mes = 'Enero';      break;
                case '02': $mes = 'Febrero';    break;
                case '03': $mes = 'Marzo';      break;
                case '04': $mes = 'Abril';      break;
                case '05': $mes = 'Mayo';       break;
                case '06': $mes = 'Junio';      break;
                case '07': $mes = 'Julio';      break;
                case '08': $mes = 'Agosto';     break;
                case '09': $mes = 'Septiembre'; break;
                case '10': $mes = 'Octubre';    break;
                case '11': $mes = 'Noviembre';  break;
                case '12': $mes = 'Diciembre';  break;
            }
            
            // Convertir la fecha
            return $date->format('j').' de '.$mes.' de '.$date->format('Y');
        }
        
        /**
         * Convierte la fecha "2017-12-01 23:30:59" en "01/12/2017 23:30"
         * @param type $fecha
         * @return type
         */
        public function fecha_formato_listado($fecha = '', $solo_fecha = 0)
        {
            // Convertir la fecha
            $date = new DateTime($fecha);
            if ($solo_fecha) {
                return $date->format('d/m/Y');
            }
            else {
                return $date->format('d/m/Y H:i');
            }
        }
        
        /**
         * Función para obtener el nombre de un usuario dado el ID
         * @param type $id
         * @return type
         */
        public function nombre_usuario($id = 0) 
        {
            $nombre = '';
            if ($id > 0) {
                $usuario = Yii::app()->db->createCommand(array(
                    'select' => array('nombre'),
                    'from' => 'usuario',
                    'where' => 'id=:id',
                    'params' => array(':id'=>$id)
                ))->queryRow();
                if ($usuario) {
                    $nombre = $usuario['nombre'];
                }
            }
            return $nombre;
        }
        
        /**
         * Función para devolver el estado del experimento en formato texto
         * @param type $estado
         * @return string
         */
        public function estado_experimento_txt($estado = '')
        {
            $estado_txt = '';
            if ($estado != '') {
                switch ($estado) {
                    case 'INICIADO':    $estado_txt = 'Iniciado';   break;
                    case 'PREPARADO':   $estado_txt = 'Preparado';  break;
                    case 'EN_CURSO':    $estado_txt = 'En curso';   break;
                    case 'FINALIZADO':  $estado_txt = 'Finalizado'; break;
                }
            }
            return $estado_txt;
        }
        
        /**
         * Función para devolver el icono del estado actual del experimento
         * @param type $estado
         * @return string
         */
        public function estado_experimento_icono($estado = '')
        {
            $icono = '';
            if ($estado != '') {
                switch ($estado) {
                    case 'INICIADO':    $icono = 'icon-home';           break;
                    case 'PREPARADO':   $icono = 'icon-puzzle-piece';   break;
                    case 'EN_CURSO':    $icono = 'icon-cog';            break;
                    case 'FINALIZADO':  $icono = 'icon-flag';           break;
                }
            }
            return $icono;
        }
        
        /**
         * Función para limpiar un texto de etiquetas para insertar en la tabla de logs
         * @param type $txt
         * @return type
         */
        public function log_limpiar_texto($txt = '')
        {
            if (strlen($txt) > 0) {
                $txt = strip_tags($txt);
                $txt = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $txt);
            }
            return $txt;
        }
        
        /**
         * Función para obtener toda la información necesaria y dar formato a los logs para mostrar por pantalla
         * @param type $logs
         * @return type
         */
        public function obtener_formato_logs($logs = array())
        {
            if (count($logs) > 0) {
                // 1) Obtener todos los nombres de usuario del sistema
                $command = Yii::app()->db->createCommand();
                $usuarios = $command->select('id, nombre')
                ->from('usuario')
                ->queryAll();
                
                $nombres = array();
                foreach ($usuarios as $u) {
                    $u = (object) $u;
                    $nombres[$u->id] = $u->nombre;
                }
                
                // Array de acciones en formato texto
                $acciones = array(
                    'ALTA'          => 'Insertar',
                    'BAJA'          => 'Eliminar',
                    'MODIFICACION'  => 'Modificar'
                );
                // Array de iconos asociados a las acciones
                $iconos = array(
                    'ALTA'          => 'icon-plus',
                    'BAJA'          => 'icon-trash',
                    'MODIFICACION'  => 'icon-pencil'
                );
                // Array de colores de los iconos asociados a las acciones
                $colores_iconos = array(
                    'ALTA'          => 'text-success',
                    'BAJA'          => 'text-danger',
                    'MODIFICACION'  => 'text-warning'
                );
                    
                // 2) Recorrer cada log para generar formato
                foreach ($logs as $key => $log) {
                    $log = (object) $log;
                    // 3) Asignar el nombre del usuario
                    $log->nombre_usuario = $nombres[$log->usuario_id];
                    // 4) Asignar la fecha en formato corto
                    $log->fecha_txt = $this->fecha_formato_listado($log->fecha);
                    // 5) Asignar la acción en formato texto
                    $log->accion_txt = $acciones[$log->accion];
                    // 6) Asignar el icono de la acción
                    $log->icono = $iconos[$log->accion];
                    // 7) Asignar los colores de los iconos
                    $log->color_icono = $colores_iconos[$log->accion];
                    // 8) Valores por defecto para descripción e información
                    $log->descripcion = '';
                    $log->informacion = '';
                    
                    // 9) Dependiendo de la tabla, obtener el formato particular
                    switch ($log->tabla) {
                        case 'experimento':         $log = $this->_formato_log_experimento($log);           break;
                        case 'experimento_producto':$log = $this->_formato_log_experimento_producto($log);  break;
                        case 'experimento_serie':   $log = $this->_formato_log_experimento_serie($log);     break;
                        case 'experimento_equipo':  $log = $this->_formato_log_experimento_equipo($log);    break;
                        case 'experimento_estado':  $log = $this->_formato_log_experimento_estado($log);    break;
                        case 'tarea':               $log = $this->_formato_log_tarea($log);    break;
                    }
                    $logs[$key] = $log;
                }
            }
            return $logs;
        }
        
        /**
         * Formato para los logs asociados a la tabla "experimento"
         * @param type $log
         * @return type
         */
        private function _formato_log_experimento($log = null)
        {
            $command = Yii::app()->db->createCommand();
            // Dependiendo la acción, el formato de texto a asignar en la descripción e información
            switch ($log->accion) {
                case 'ALTA':
                    // Obtener la información necesaria del experimento
                    if (isset($log->id_asociado) && $log->id_asociado > 0) {
                        $experimento = $command->select('id, titulo')
                        ->from('experimento')
                        ->where('id='.$log->id_asociado)
                        ->queryRow();
                        if ($experimento) {
                            $experimento = (object) $experimento;
                            $log->descripcion = 'Se creó el experimento '.$experimento->id.': "'.$experimento->titulo.'"';
                           
                            if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                                $valores = explode(';;;', $log->info_adicional);
                                $log->informacion = '';
                                foreach ($valores as $valor) {
                                    if ($log->informacion != '') $log->informacion .= '<br>';
                                    $valor = explode('>>>', $valor);
                                    $log->informacion .= '<strong>'.$valor[0].'</strong>: '.trim($valor[1]);
                                }
                            }
                        }
                    }
                    break;
                case 'BAJA':
                    $log->descripcion = 'Se eliminó el experimento ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'id':      $log->descripcion .= trim($valor[1]).': '; break;
                                case 'titulo':  $log->descripcion .= '"'.trim($valor[1]).'"'; break;
                            }
                        }
                    }
                    break;
                case 'MODIFICACION':
                    // Obtener la información necesaria del experimento
                    if (isset($log->id_asociado) && $log->id_asociado > 0) {
                        $experimento = $command->select('id, titulo')
                        ->from('experimento')
                        ->where('id='.$log->id_asociado)
                        ->queryRow();
                        if ($experimento) {
                            $experimento = (object) $experimento;
                            $log->descripcion = 'Se modificó el experimento '.$experimento->id.': "'.$experimento->titulo.'"';
                           
                            if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                                $log->informacion = '';
                                $valores = explode(';;;', $log->info_adicional);
                                foreach ($valores as $valor) {
                                    if ($log->informacion != '') $log->informacion .= '<br>';
                                    if (strpos($valor, '<<<') !== false) { // Valor antes
                                        $valor = explode('<<<', $valor);
                                        if ($valor[0] == 'estado')
                                            $log->informacion .= '<strong>Estado</strong> (Antes): '.$this->estado_experimento_txt($valor[1]);
                                        else
                                            $log->informacion .= '<strong>'.$valor[0].'</strong> (Antes): '.trim($valor[1]);
                                    }
                                    else {
                                        if (strpos($valor, '>>>') !== false) { // Valor después
                                            $valor = explode('>>>', $valor);
                                            if ($valor[0] == 'estado')
                                                $log->informacion .= '<strong>Estado</strong> (Después): '.$this->estado_experimento_txt($valor[1]);
                                            else
                                                $log->informacion .= '<strong>'.$valor[0].'</strong> (Después): '.trim($valor[1]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
            return $log;
        }
        
        /**
         * Formato para los logs asociados a la tabla "experimento_producto"
         * @param type $log
         * @return type
         */
        private function _formato_log_experimento_producto($log = null)
        {
            $command = Yii::app()->db->createCommand();
            // Dependiendo la acción, el formato de texto a asignar en la descripción e información
            switch ($log->accion) {
                case 'ALTA':
                    $log->descripcion = 'Se agregó un producto ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $log->descripcion .= 'al experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'producto_id':
                                    $command->reset();
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $producto = $command->select('p.id, p.nombre, ep.producto_usa_serie, ep.cantidad')
                                        ->from('producto p')
                                        ->leftJoin('experimento_producto ep', 'ep.producto_id=p.id')
                                        ->where('p.id='.$valor[1])
                                        ->queryRow();
                                        if ($producto) {
                                            $p = (object) $producto;
                                            $log->informacion .= '<strong>Producto</strong> '.$p->id.': '.$p->nombre;
                                            $usa_serie = ($p->producto_usa_serie) ? 'Si' : 'No';
                                            $log->informacion .= '<br><strong>Usa serie</strong>: '.$usa_serie;
                                            $log->informacion .= '<br><strong>Cantidad</strong>: '.$p->cantidad;
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    break;
                case 'BAJA':
                    $log->descripcion = 'Se eliminó un producto ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $log->descripcion .= 'del experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'producto_id':
                                    $command->reset();
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $producto = $command->select('id, nombre')
                                        ->from('producto')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($producto) {
                                            $p = (object) $producto;
                                            $log->informacion .= '<strong>Producto</strong> '.$p->id.': '.$p->nombre;
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    break;
            }
            return $log;
        }
        
        /**
         * Formato para los logs asociados a la tabla "experimento_serie"
         * @param type $log
         * @return type
         */
        private function _formato_log_experimento_serie($log = null)
        {
            $command = Yii::app()->db->createCommand();
            // Dependiendo la acción, el formato de texto a asignar en la descripción e información
            switch ($log->accion) {
                case 'ALTA':
                    $log->descripcion = 'Se asoció un producto con serie ';
                    $log->informacion = '';
                    // Obtener la información necesaria del experimento_serie
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $log->descripcion .= 'al experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'serie':
                                    $command->reset();
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $producto = $command->select('p.id, p.nombre')
                                        ->from('producto p')
                                        ->join('serie s', 's.producto_id=p.id')
                                        ->where('s.serie=\''.$valor[1].'\'')
                                        ->queryRow();
                                        if ($producto) {
                                            $p = (object) $producto;
                                            $log->informacion .= '<strong>Producto</strong> '.$p->id.': '.$p->nombre.'<br>';
                                        }
                                        $log->informacion .= '<strong>Serie</strong> '.$valor[1];
                                    }
                                    break;
                            }
                        }
                    }
                    break;
                case 'BAJA':
                    $log->descripcion = 'Se eliminaron todas las series de un producto, ';
                    $desc_experimento = '';
                    $desc_producto = '';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $desc_experimento = 'del experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'producto_id':
                                    $command->reset();
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $producto = $command->select('id, nombre')
                                        ->from('producto')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($producto) {
                                            $p = (object) $producto;
                                            $log->informacion = '';
                                            $log->informacion .= '<strong>Producto</strong> '.$p->id.': '.$p->nombre;
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    $log->descripcion .= $desc_producto.$desc_experimento;
                    break;
            }
            return $log;
        }
        
        /**
         * Formato para los logs asociados a la tabla "experimento_equipo"
         * @param type $log
         * @return type
         */
        private function _formato_log_experimento_equipo($log = null)
        {
            $command = Yii::app()->db->createCommand();
            // Dependiendo la acción, el formato de texto a asignar en la descripción e información
            switch ($log->accion) {
                case 'ALTA':
                    // Obtener la información necesaria del experimento_equipo
                    if (isset($log->id_asociado) && $log->id_asociado > 0) {
                        $experimento_equipo = $command->select('ee.*, e.titulo as nombre_experimento, eq.nombre as nombre_equipo, eq.estado')
                        ->from('experimento_equipo ee')
                        ->join('experimento e', 'e.id=ee.experimento_id')
                        ->join('equipo eq', 'eq.id=ee.equipo_id')
                        ->where('ee.id='.$log->id_asociado)
                        ->queryRow();
                        if ($experimento_equipo) {
                            $ee = (object) $experimento_equipo;
                            $log->descripcion = 'Se agregó un equipo al experimento '.$ee->experimento_id.': "'.$ee->nombre_experimento.'"';
                            $log->informacion = '';
                            $log->informacion .= '<strong>Equipo</strong> '.$ee->equipo_id.': '.$ee->nombre_equipo;
                            $log->informacion .= '<br><strong>Estado</strong>: '.$ee->estado;
                        }
                    }
                    break;
                case 'BAJA':
                    $log->descripcion = 'Se eliminó un equipo ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $log->descripcion .= 'del experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'equipo_id':
                                    $command->reset();
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $equipo = $command->select('id, nombre')
                                        ->from('equipo')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($equipo) {
                                            $e = (object) $equipo;
                                            $log->informacion = '';
                                            $log->informacion .= '<strong>Equipo</strong> '.$e->id.': '.$e->nombre;
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    break;
            }
            return $log;
        }
        
        /**
         * Formato para los logs asociados a la tabla "experimento_estado"
         * @param type $log
         * @return type
         */
        private function _formato_log_experimento_estado($log = null)
        {
            $command = Yii::app()->db->createCommand();
            // Dependiendo la acción, el formato de texto a asignar en la descripción e información
            switch ($log->accion) {
                case 'ALTA':
                    $log->descripcion = 'Se agregó información adicional ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $log->descripcion .= 'al experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'mas_info':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->informacion .= '<strong>Información</strong>: '.$valor[1];
                                    }
                                    break;
                                case 'estado':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->informacion .= '<br><strong>Estado</strong>: '.$this->estado_experimento_txt($valor[1]);
                                    }
                                    break;
                            }
                        }
                    }
                    break;
                case 'BAJA':
                    $log->descripcion = 'Se eliminó información adicional ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'experimento_id':
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $command->reset();
                                        $experimento = $command->select('id, titulo')
                                        ->from('experimento')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($experimento) {
                                            $e = (object) $experimento;
                                            $log->descripcion .= 'del experimento '.$e->id.': "'.$e->titulo.'"';
                                        }
                                    }
                                    break;
                                case 'mas_info':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->informacion .= '<strong>Información</strong>: '.$valor[1];
                                    }
                                    break;
                                case 'estado':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->informacion .= '<br><strong>Estado</strong>: '.$this->estado_experimento_txt($valor[1]);
                                    }
                                    break;
                            }
                        }
                    }
                    break;
                case 'MODIFICACION':
                    $log->descripcion = 'Se modificó información adicional ';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);

                        foreach ($valores as $valor) {
                            if (strpos($valor, '<<<') !== false) { // Valor antes
                                $valor = explode('<<<', $valor);
                                switch ($valor[0]) {
                                    case 'mas_info':
                                        if (isset($valor[1]) && $valor[1] != '') {
                                            $log->informacion .= '<strong>Información</strong> (Antes): '.$valor[1];
                                        }
                                        break;
                                }
                            }
                            else {
                                if (strpos($valor, '>>>') !== false) { // Valor después
                                    $valor = explode('>>>', $valor);
                                    switch ($valor[0]) {
                                        case 'experimento_id':
                                            if (isset($valor[1]) && $valor[1] > 0) {
                                                $command->reset();
                                                $experimento = $command->select('id, titulo')
                                                ->from('experimento')
                                                ->where('id='.$valor[1])
                                                ->queryRow();
                                                if ($experimento) {
                                                    $e = (object) $experimento;
                                                    $log->descripcion .= 'del experimento '.$e->id.': "'.$e->titulo.'"';
                                                }
                                            }
                                            break;
                                        case 'mas_info':
                                            if (isset($valor[1]) && $valor[1] != '') {
                                                $log->informacion .= '<br><strong>Información</strong> (Después): '.$valor[1];
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
            return $log;
        }
        
        /**
         * Formato para los logs asociados a la tabla "tarea"
         * @param type $log
         * @return type
         */
        private function _formato_log_tarea($log = null)
        {
            $command = Yii::app()->db->createCommand();
            // Dependiendo la acción, el formato de texto a asignar en la descripción e información
            switch ($log->accion) {
                case 'ALTA':
                    $log->descripcion = 'Se agregó la tarea';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'titulo':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->descripcion .= ': '.$valor[1];
                                        $log->informacion .= '<strong>Título</strong>: '.$valor[1];
                                    }
                                    break;
                                case 'descripcion':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->informacion .= '<br><strong>Descripción</strong>: '.$valor[1];
                                    }
                                    break;
                                case 'usuario_id':
                                    $command->reset();
                                    if (isset($valor[1]) && $valor[1] > 0) {
                                        $usuario = $command->select('nombre')
                                        ->from('usuario')
                                        ->where('id='.$valor[1])
                                        ->queryRow();
                                        if ($usuario) {
                                            $u = (object) $usuario;
                                            $log->informacion .= '<strong>Asignada a</strong>: '.$u->nombre;
                                        }
                                    }
                                    break;
                            }
                        }
                    }
                    break;
                case 'BAJA':
                    $log->descripcion = 'Se eliminó la tarea';
                    $log->informacion = '';
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            $valor = explode('>>>', $valor);
                            switch ($valor[0]) {
                                case 'titulo':
                                    if (isset($valor[1]) && $valor[1] != '') {
                                        $log->descripcion .= ': '.$valor[1];
                                    }
                                    break;
                            }
                        }
                    }
                    break;
                case 'MODIFICACION':
                    $log->descripcion = 'Se modificó la tarea';
                    $log->informacion = '';
                    
                    if (isset($log->info_adicional) && strlen($log->info_adicional) > 0) {
                        $valores = explode(';;;', $log->info_adicional);
                        foreach ($valores as $valor) {
                            if ($log->informacion != '') $log->informacion .= '<br>';
                            if (strpos($valor, '<<<') !== false) { // Valor antes
                                $valor = explode('<<<', $valor);
                                $log->informacion .= '<strong>'.$valor[0].'</strong> (Antes): '.trim($valor[1]);
                            }
                            else {
                                if (strpos($valor, '>>>') !== false) { // Valor después
                                    $valor = explode('>>>', $valor);
                                    if ($valor[0] == 'titulo_tarea') {
                                        $log->descripcion .= ': '.$valor[1];
                                    }  
                                    else {
                                        if ($valor[0] == 'Estado') {
                                            if ($valor[1] == 'Completa')
                                                $log->descripcion = str_replace('modificó', 'completó', $log->descripcion);
                                            $log->informacion .= '<strong>'.$valor[0].'</strong> (Después): '.trim($valor[1]);
                                        }
                                        else
                                            $log->informacion .= '<strong>'.$valor[0].'</strong> (Después): '.trim($valor[1]);
                                    }
                                }
                            }
                        }
                    }
                    break;
            }
            return $log;
        }
        
        public function verificarNoDefinido($input)
        {
            $output = 'No definido';
            if (trim($input) != '') {
                $output = $input;
            }
            return $output;
        }
        
        /**
         * Función para crear el LOG de la creación
         * @param type $tipo
         * @param type $tabla
         * @param type $id
         */
        public function log_create($tipo, $tabla, $id)
        {
            // Información del LOG
            $info_adicional = '';
            foreach ($_POST[$tipo] as $campo => $valor) {
                if ($info_adicional != '')
                    $info_adicional .= ';;;';
                $info_adicional .= $campo.'>>>'.$this->log_limpiar_texto($valor);
            }

            // LOG del sistema
            $log_params = array(
                'accion'    => 'ALTA',
                'tabla'     => $tabla,
                'id'        => $id,
                'relacion'  => $tabla.$id.';',
                'info'      => $info_adicional
            );
            $this->log($log_params);
        }
        
        /**
         * Función para crear el LOG de la edición
         * @param type $tipo
         * @param type $tabla
         * @param type $model
         */
        public function log_update($tipo, $tabla, $model)
        {
            // Verificar los cambios realizados
            $id = $model->id;
            $cambios = '';
            foreach ($_POST[$tipo] as $campo => $valor) {
                if ($model->$campo != $_POST[$tipo][$campo]) {
                    if ($cambios != '')
                        $cambios .= ';;;';
                    $cambios .= $campo.'<<<'.$this->log_limpiar_texto($model->$campo).';;;'.$campo.'>>>'.$this->log_limpiar_texto($_POST[$tipo][$campo]);
                }
            }
            // LOG del sistema si hubo cambios
            if ($cambios != '') {
                $log_params = array(
                    'accion'    => 'MODIFICACION',
                    'tabla'     => $tabla,
                    'id'        => $id,
                    'relacion'  => $tabla.$id.';',
                    'info'      => $cambios
                );
                $this->log($log_params);
            }
        }
}