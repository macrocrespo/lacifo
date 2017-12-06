<?php

/**
 * This is the model class for table "experimento".
 *
 * The followings are the available columns in table 'experimento':
 * @property integer $id
 * @property string $usuario_id
 * @property string $consumidor_id
 * @property string $fecha
 * @property string $titulo
 * @property string $descripcion
 * @property string $condiciones
 * @property string $resultados
 * @property double $total
 */
class Experimento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'experimento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('titulo', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('usuario_id, consumidor_id', 'length', 'max'=>45),
			array('titulo', 'length', 'max'=>250),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario_id, consumidor_id, fecha, titulo, descripcion, condiciones, resultados, total', 'safe', 'on'=>'search'),
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
                    'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
                    'estado'    => array(self::HAS_MANY, 'ExperimentoEstado', 'experimento_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Identificador único del experimento ',
			'usuario_id' => 'Usuario que generó el experimento',
			'consumidor_id' => 'Identificador del consumidor que llevará a cabo el consumo de insumos dentro del experimento',
			'fecha' => 'Fecha en que se generó el experimento
',
			'titulo' => 'Titulo',
                        'estado' => 'Estado',
			'descripcion' => 'Descripcion',
			'condiciones' => 'Condiciones',
			'resultados' => 'Resultados',
			'total' => 'Total',
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
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('consumidor_id',$this->consumidor_id,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('titulo',$this->titulo,true);
                $criteria->compare('estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('condiciones',$this->condiciones,true);
		$criteria->compare('resultados',$this->resultados,true);
		$criteria->compare('total',$this->total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Experimento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
