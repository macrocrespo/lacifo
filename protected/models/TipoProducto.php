<?php

/**
 * This is the model class for table "tipo_producto".
 *
 * The followings are the available columns in table 'tipo_producto':
 * @property string $id
 * @property string $rubro_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $inicial
 * @property integer $estado
 */
class TipoProducto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('nombre, descripcion, inicial, estado, rubro_id', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('rubro_id', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>20),
			array('descripcion', 'length', 'max'=>100),
			array('inicial', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rubro_id, nombre, descripcion, inicial, estado', 'safe', 'on'=>'search'),
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
                    'rubro' => array(self::BELONGS_TO, 'Rubro', 'rubro_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rubro_id' => 'Rubro',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción',
			'inicial' => 'Inicial',
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
		$criteria->compare('rubro_id',$this->rubro_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('inicial',$this->inicial,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoProducto the static model class
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
}
