<?php

/**
 * This is the model class for table "producto".
 *
 * The followings are the available columns in table 'producto':
 * @property string $id
 * @property string $contenedor_id
 * @property string $tipo_producto_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $nombre_ingles
 * @property string $marca
 * @property string $IUPAC
 * @property string $CAS
 * @property integer $usa_serie
 * @property integer $usa_detalle
 * @property integer $estado
 */
class Producto extends CActiveRecord
{
    
        public $rubro;
        public $deposito;
        
        public $rc_cantidad;
        public $rc_precio;
        public $rc_total;
        public $rc_estado;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'producto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rubro, deposito, nombre, descripcion, contenedor_id, tipo_producto_id, marca, IUPAC, estado', 'required'),
                        array('usa_serie, usa_detalle, estado', 'numerical', 'integerOnly'=>true),
			array('contenedor_id, tipo_producto_id', 'length', 'max'=>10),
			array('nombre, descripcion, nombre_ingles', 'length', 'max'=>100),
			array('marca, IUPAC, CAS', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contenedor_id, tipo_producto_id, nombre, descripcion, nombre_ingles, marca, IUPAC, CAS, usa_serie, usa_detalle, estado', 'safe', 'on'=>'search'),
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
                    'contenedor' => array(self::BELONGS_TO, 'Contenedor', 'contenedor_id'),
                    'tipo_producto' => array(self::BELONGS_TO, 'TipoProducto', 'tipo_producto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                        'deposito' => 'Depósito',
			'contenedor_id' => 'Contenedor',
			'tipo_producto_id' => 'Tipo de producto',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción',
			'nombre_ingles' => 'Nombre en inglés',
			'marca' => 'Marca',
			'IUPAC' => 'IUPAC#',
			'CAS' => 'CAS',
			'usa_serie' => 'Usa serie?',
			'usa_detalle' => 'Usa detalle?',
			'estado' => 'Estado',
                        'rc_cantidad'=> 'Cantidad',
                        'rc_precio'=> 'Costo',
                        'rc_total'=> 'Total',
                        'rc_estado'=> 'Estado',
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
		$criteria->compare('contenedor_id',$this->contenedor_id,true);
		$criteria->compare('tipo_producto_id',$this->tipo_producto_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('nombre_ingles',$this->nombre_ingles,true);
		$criteria->compare('marca',$this->marca,true);
		$criteria->compare('IUPAC',$this->IUPAC,true);
		$criteria->compare('CAS',$this->CAS,true);
		$criteria->compare('usa_serie',$this->usa_serie);
		$criteria->compare('usa_detalle',$this->usa_detalle);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Producto the static model class
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
