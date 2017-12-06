<?php

/**
 * This is the model class for table "tmp_renglon_compra".
 *
 * The followings are the available columns in table 'renglon_compra':
 * @property integer $id
 * @property integer $cantidad
 * @property string $precio
 * @property string $total
 * @property integer $compra_id
 * @property string $producto_id
 * @property integer $estado
 */
class TempRenglonCompra extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmp_renglon_compra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('compra_id, producto_id', 'required'),
			array('id, cantidad, compra_id, estado', 'numerical', 'integerOnly'=>true),
			array('precio, total, producto_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cantidad, precio, total, compra_id, producto_id, estado', 'safe', 'on'=>'search'),
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
			'id' => 'Identicador único del renglón de una compra',
			'cantidad' => 'Cantidad de productos comprados',
			'precio' => 'Precio pagado en el compra',
			'total' => 'Producto de cantidad comprado por el precio de compra',
			'compra_id' => 'Compra',
			'producto_id' => 'Relación del renglón de compra con el producto que se está comprando',
			'estado' => '1: Activo, 0:Inactivo',
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
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('precio',$this->precio,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('compra_id',$this->compra_id);
		$criteria->compare('producto_id',$this->producto_id,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RenglonCompra the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function agregar($renglon) {
            $rc = new $this;
            foreach ($renglon as $field => $value) {
                $rc->$field = $value;
            }
            $rc->save();
        }
        
        public function editar($renglon) {
            $rc = $this->find('producto_id = '.$renglon['producto_id'].' AND compra_id = '.$renglon['compra_id']);
            $rc->cantidad   = $renglon['cantidad'];
            $rc->precio     = $renglon['precio'];
            $rc->total      = $renglon['total'];
            $rc->save();
        }
        
        public function eliminar($renglon) {
            $rc = $this->find('producto_id = '.$renglon['producto_id'].' AND compra_id = '.$renglon['compra_id']);
            $rc->delete();
        }
}
