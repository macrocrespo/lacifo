<?php

/**
 * This is the model class for table "stock".
 *
 * The followings are the available columns in table 'stock':
 * @property string $id
 * @property string $producto_id
 * @property string $minimo
 * @property string $maximo
 * @property string $sugerido
 * @property string $cantidad
 * @property string $usuario_ingresa_id
 * @property string $fecha_ingresa
 * @property string $usuario_consume_id
 * @property string $fecha_consume
 */
class Stock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('producto_id, minimo, maximo, sugerido, cantidad', 'required'),
			array('producto_id, minimo, maximo, sugerido, cantidad, usuario_ingresa_id, usuario_consume_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, producto_id, minimo, maximo, sugerido, cantidad, usuario_ingresa_id, fecha_ingresa, usuario_consume_id, fecha_consume', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'producto_id' => 'Producto',
			'minimo' => 'Mínimo',
			'maximo' => 'Máximo',
			'sugerido' => 'Sugerido',
			'cantidad' => 'Cantidad actual',
			'usuario_ingresa_id' => 'Usuario que ingresa',
			'fecha_ingresa' => 'Fecha de ingreso',
			'usuario_consume_id' => 'Usuario que consume',
			'fecha_consume' => 'Fecha de consumo',
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
		$criteria->compare('producto_id',$this->producto_id,true);
		$criteria->compare('minimo',$this->minimo,true);
		$criteria->compare('maximo',$this->maximo,true);
		$criteria->compare('sugerido',$this->sugerido,true);
		$criteria->compare('cantidad',$this->cantidad,true);
		$criteria->compare('usuario_ingresa_id',$this->usuario_ingresa_id,true);
		$criteria->compare('fecha_ingresa',$this->fecha_ingresa,true);
		$criteria->compare('usuario_consume_id',$this->usuario_consume_id,true);
		$criteria->compare('fecha_consume',$this->fecha_consume,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
