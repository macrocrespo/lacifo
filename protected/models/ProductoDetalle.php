<?php

/**
 * This is the model class for table "producto_detalle".
 *
 * The followings are the available columns in table 'producto_detalle':
 * @property integer $id
 * @property string $producto_id
 * @property string $unidad_medida
 * @property string $formula_quimica
 * @property string $imagen
 * @property string $peso_molecular
 * @property string $laboratorio
 */
class ProductoDetalle extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'producto_detalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('producto_id', 'required'),
			array('producto_id', 'length', 'max'=>10),
			array('unidad_medida', 'length', 'max'=>4),
			array('formula_quimica, laboratorio', 'length', 'max'=>100),
			array('imagen', 'length', 'max'=>50),
			array('fraccion, peso_molecular', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, producto_id, unidad_medida, formula_quimica, imagen, peso_molecular, laboratorio', 'safe', 'on'=>'search'),
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
                        'fraccion' => 'Fracción',
			'unidad_medida' => 'Unidad de medida',
			'formula_quimica' => 'Fórmula Química',
			'imagen' => 'Imagen',
			'peso_molecular' => 'Peso Molecular',
			'laboratorio' => 'Laboratorio',
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
		$criteria->compare('producto_id',$this->producto_id,true);
		$criteria->compare('unidad_medida',$this->unidad_medida,true);
		$criteria->compare('formula_quimica',$this->formula_quimica,true);
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('peso_molecular',$this->peso_molecular,true);
		$criteria->compare('laboratorio',$this->laboratorio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductoDetalle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
