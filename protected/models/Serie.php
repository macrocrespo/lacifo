<?php

/**
 * This is the model class for table "serie".
 *
 * The followings are the available columns in table 'serie':
 * @property string $serie
 * @property string $vencimiento
 * @property string $producto_id
 * @property integer $renglon_compra_id
 * @property integer $renglon_consumo_id
 */
class Serie extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'serie';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renglon_compra_id, renglon_consumo_id', 'numerical', 'integerOnly'=>true),
			array('serie', 'length', 'max'=>20),
			array('producto_id', 'length', 'max'=>10),
			array('vencimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('serie, vencimiento, producto_id, renglon_compra_id, renglon_consumo_id', 'safe', 'on'=>'search'),
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
			'serie' => 'Serie',
			'vencimiento' => 'Vencimiento',
			'producto_id' => 'Producto',
			'renglon_compra_id' => 'Renglon Compra',
			'renglon_consumo_id' => 'Renglon Consumo',
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

		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('vencimiento',$this->vencimiento,true);
		$criteria->compare('producto_id',$this->producto_id,true);
		$criteria->compare('renglon_compra_id',$this->renglon_compra_id);
		$criteria->compare('renglon_consumo_id',$this->renglon_consumo_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Serie the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
