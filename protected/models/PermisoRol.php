<?php

/**
 * This is the model class for table "permiso_rol".
 *
 * The followings are the available columns in table 'permiso_rol':
 * @property string $id
 * @property string $seccion_id
 * @property string $rol_id
 */
class PermisoRol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'permiso_rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seccion_id, rol_id', 'required'),
			array('seccion_id, rol_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, seccion_id, rol_id', 'safe', 'on'=>'search'),
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
                    'rol' => array(self::BELONGS_TO, 'Rol', 'rol_id'),
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
			'rol_id' => 'Rol',
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
		$criteria->compare('rol_id',$this->rol_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PermisoRol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Función para asigar un permiso a un rol
         * @param type $id
         * @param type $seccion_id
         */
        public function asignar_permiso_a_rol($id, $seccion_id) {
            PermisoUsuario::model()->asignar_permisos_a_usuarios_por_rol($id, $seccion_id);
            $permiso = new $this;
            $permiso->rol_id = $id;
            $permiso->seccion_id = $seccion_id;
            $permiso->save();
        }
        
        /**
         * Función para quitar el permiso a un rol y a todos los usuarios dependientes
         * @param type $id
         */
        public function quitar_permiso_a_rol($id = 0) {
            if ($id > 0) {
                $permiso = $this->findByPk($id);
                // Obtener todos los usuarios asociados al rol
                $usuarios = Usuario::model()->findAll('rol_id = '.$permiso->rol_id);
                foreach ($usuarios as $u) {
                    if (PermisoUsuario::model()->tiene_permiso($u->id, $permiso->seccion_id)) {
                        $condicion = 'usuario_id = '.$u->id.' and seccion_id = '.$permiso->seccion_id;
                        $permiso_usuario = PermisoUsuario::model()->find($condicion);
                        PermisoUsuario::model()->quitar_permiso_a_usuario($permiso_usuario->id);
                    }
                }
                $this->findByPk($id)->delete();
            }
        }
}
