<?php

/**
 * This is the model class for table "productos".
 *
 * The followings are the available columns in table 'productos':
 * @property integer $id
 * @property integer $familia_id
 * @property string $nombre
 * @property string $nombre_adic
 * @property integer $costo
 * @property integer $habilita
 * @property string $fecha_alta
 * @property string $fecha_modi
 * @property integer $usuario_alta_id
 * @property integer $usuario_modi_id
 *
 * The followings are the available model relations:
 * @property FliaProductos $familia
 * @property Usuarios $usuarioAlta
 * @property Usuarios $usuarioModi
 */
class Productos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'productos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('familia_id, nombre, nombre_adic, costo, habilita, usuario_alta_id, usuario_modi_id', 'required'),
			array('familia_id, costo, habilita, usuario_alta_id, usuario_modi_id', 'numerical', 'integerOnly'=>true),
			array('nombre, nombre_adic', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, familia_id, nombre, nombre_adic, costo, habilita, fecha_alta, fecha_modi, usuario_alta_id, usuario_modi_id', 'safe', 'on'=>'search'),
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
			'familia' => array(self::BELONGS_TO, 'FliaProductos', 'familia_id'),
			'usuarioAlta' => array(self::BELONGS_TO, 'Usuarios', 'usuario_alta_id'),
			'usuarioModi' => array(self::BELONGS_TO, 'Usuarios', 'usuario_modi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'familia_id' => 'Familia',
			'nombre' => 'Nombre',
			'nombre_adic' => 'Nombre Adic',
			'costo' => 'Costo',
			'habilita' => 'Habilita',
			'fecha_alta' => 'Fecha Alta',
			'fecha_modi' => 'Fecha Modi',
			'usuario_alta_id' => 'Usuario Alta',
			'usuario_modi_id' => 'Usuario Modi',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('familia_id',$this->familia_id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('nombre_adic',$this->nombre_adic,true);
		$criteria->compare('costo',$this->costo);
		$criteria->compare('habilita',$this->habilita);
		$criteria->compare('fecha_alta',$this->fecha_alta,true);
		$criteria->compare('fecha_modi',$this->fecha_modi,true);
		$criteria->compare('usuario_alta_id',$this->usuario_alta_id);
		$criteria->compare('usuario_modi_id',$this->usuario_modi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Productos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
