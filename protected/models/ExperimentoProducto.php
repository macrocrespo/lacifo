<?php

/**
 * This is the model class for table "experimento_producto".
 *
 * The followings are the available columns in table 'experimento_producto':
 * @property integer $id
 * @property integer $producto_id
 * @property integer $producto_usa_serie
 * @property integer $cantidad
 * @property double $subtotal
 * @property double $costo
 */
class ExperimentoProducto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'experimento_producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('producto_id, producto_usa_serie, cantidad, subtotal, costo', 'required'),
			array('producto_id, producto_usa_serie, cantidad', 'numerical', 'integerOnly'=>true),
			array('subtotal, costo', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, producto_id, producto_usa_serie, cantidad, subtotal, costo', 'safe', 'on'=>'search'),
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
			'producto_usa_serie' => 'Producto Usa Serie',
			'cantidad' => 'Cantidad',
			'subtotal' => 'Subtotal',
			'costo' => 'Costo',
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
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('producto_usa_serie',$this->producto_usa_serie);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('subtotal',$this->subtotal);
		$criteria->compare('costo',$this->costo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExperimentoProducto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
