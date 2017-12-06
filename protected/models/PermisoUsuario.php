<?php

/**
 * This is the model class for table "permiso_usuario".
 *
 * The followings are the available columns in table 'permiso_usuario':
 * @property string $id
 * @property string $seccion_id
 * @property string $usuario_id
 */
class PermisoUsuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'permiso_usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seccion_id, usuario_id', 'required'),
			array('seccion_id, usuario_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, seccion_id, usuario_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'seccion' => array(self::BELONGS_TO, 'Seccion', 'seccion_id'),
                    'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'seccion_id' => 'Seccion',
			'usuario_id' => 'Usuario',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('seccion_id',$this->seccion_id,true);
		$criteria->compare('usuario_id',$this->usuario_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PermisoUsuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Función para asignar el permiso a un usuario
         * @param type $id
         * @param type $seccion_id
         */
        public function asignar_permiso_a_usuario($id, $seccion_id) {
            $permiso = new $this;
            $permiso->usuario_id = $id;
            $permiso->seccion_id = $seccion_id;
            $permiso->save();
        }
        
        /**
         * Función para asignar permisos a usuarios dependientes del rol
         * @param type $rol_id
         * @param type $seccion_id
         */
        public function asignar_permisos_a_usuarios_por_rol($rol_id, $seccion_id) {
            // Obtengo todos los usuarios que pertenecen al rol
            $usuarios = Usuario::model()->findAll('rol_id = '.$rol_id);
            foreach ($usuarios as $u) {
                if (!$this->tiene_permiso($u->id, $seccion_id))
                    $this->asignar_permiso_a_usuario($u->id, $seccion_id);
            }
        }
        
        /**
         * Función para comprobar si un usuario tiene un determinado permiso
         * @param type $usuario_id
         * @param type $seccion_id
         * @return boolean
         */
        public function tiene_permiso($usuario_id = 0, $seccion_id = 0) {
            $result = false;
            if ($usuario_id > 0 && $seccion_id > 0) {
                $condicion = 'usuario_id = '.$usuario_id.' AND seccion_id = '.$seccion_id;
                $permiso = $this->findAll($condicion);
                if ($permiso)
                    $result = true;
            }
            return $result;
        }
        
        /**
         * Función para quitar el permiso a un usuario
         * @param type $id
         */
        public function quitar_permiso_a_usuario($id = 0) {
            if ($id > 0) {
                $this->findByPk($id)->delete();
            }
        }
        
        /**
         * Función para heredar los permisos de un rol a un determinado usuario
         * @param type $usuario_id
         * @param type $rol_id
         */
        public function heredar_permisos_desde_rol($usuario_id = 0, $rol_id = 0) {
            if ($usuario_id > 0 && $rol_id > 0) {
                // Obtener los permisos asociados al rol
                $permisos = PermisoRol::model()->findAll('rol_id = '.$rol_id);
                foreach ($permisos as $p) {
                    $this->asignar_permiso_a_usuario($usuario_id, $p->seccion_id);
                }
            }
        }
        
        /**
         * Función para reemplazar los permisos de un usuario
         * por los permisos de un nuevo rol asignado
         * @param type $usuario_id
         * @param type $rol_id
         */
        public function reemplazar_permisos_desde_rol($usuario_id = 0, $rol_id = 0) {
            if ($usuario_id > 0 && $rol_id > 0) {
                // Eliminar los permisos actuales del usuario
                $this->deleteAll('usuario_id = '.$usuario_id);
                // Heredar los permisos del nuevo rol
                $this->heredar_permisos_desde_rol($usuario_id, $rol_id);
            }
        }
}
