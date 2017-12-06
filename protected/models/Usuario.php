<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property string $id
 * @property string $rol_id
 * @property string $nombre
 * @property string $username
 * @property string $password
 * @property string $telefono_trabajo
 * @property string $telefono_personal
 * @property string $mail
 * @property string $imagen
 * @property integer $estado
 */
class Usuario extends CActiveRecord
{    
        public $password_repeat;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rol_id, nombre, password, password_repeat, mail, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('rol_id', 'length', 'max'=>10),
			array('nombre, mail, imagen', 'length', 'max'=>50),
			array('username, password', 'length', 'max'=>20),
			array('telefono_trabajo, telefono_personal', 'length', 'max'=>30),
                        array('mail', 'email'),
                        array('password', 'compare', 'compareAttribute' => 'password_repeat'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rol_id, nombre, username, password, telefono_trabajo, telefono_personal, mail, imagen, estado', 'safe', 'on'=>'search'),
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
			'rol_id' => 'Rol',
			'nombre' => 'Nombre',
			'username' => 'Nombre de usuario',
			'password' => 'Contraseña',
                        'password_repeat' => 'Confirmar contraseña',
			'telefono_trabajo' => 'Telefono de Trabajo',
			'telefono_personal' => 'Telefono Personal',
			'mail' => 'Dirección de Mail',
			'imagen' => 'Imagen',
			'estado' => 'Estado',
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
		$criteria->compare('rol_id',$this->rol_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('telefono_trabajo',$this->telefono_trabajo,true);
		$criteria->compare('telefono_personal',$this->telefono_personal,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getNombreEstado($estado = '')
        {
            $nombre_estado = 'Desconocido';
            switch($estado)
            {
                case 1:
                    $nombre_estado = 'Activo';
                    break;
                case 0:
                    $nombre_estado = 'Inactivo';
                    break;
            }
            return $nombre_estado;
        }
        
        protected function beforeSave()
        {
          if ( $this->isNewRecord )
             $this->encriptarPassword();
          else {
              $this->verificarPassword();
              
          }
          return parent::beforeSave();
        }
        
        public function encriptarPassword()
        {
            $this->password = md5($this->password);
        }
        
        public function verificarPassword() {
            if ($this->password == 'password') {
                $usuario=$this->findByPk($this->id);
                $this->password = $usuario->password;
            }
            else {
                $this->encriptarPassword();
            }
        }
        
        public function getImagen($imagen = '') {
            $images_path = Yii::app()->request->baseUrl.'/images/';
            $image_to_return = $images_path.'default_user.png';
            if ($imagen != '') {
                if (file_exists('images/usuarios/'.$imagen))
                    $image_to_return = $images_path.'usuarios/'.$imagen;
            }
            return $image_to_return;
        }
        
        
}
