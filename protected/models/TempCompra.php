<?php

/**
 * This is the model class for table "tmp_compra".
 *
 * The followings are the available columns in table 'tmp_compra':
 * @property integer $id
 * @property string $fecha
 * @property string $total
 * @property string $observacion
 * @property integer $estado
 * @property integer $usuario_id
 * @property integer $proveedor_id
 */
class TempCompra extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tmp_compra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('proveedor_id, usuario_id', 'required'),
			array('id, estado, usuario_id, proveedor_id', 'numerical', 'integerOnly'=>true),
			array('total', 'length', 'max'=>10),
			array('observacion', 'length', 'max'=>100),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, total, observacion, estado, usuario_id, proveedor_id', 'safe', 'on'=>'search'),
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
                    'proveedor' => array(self::BELONGS_TO, 'Proveedor', 'proveedor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Código de compra',
			'fecha' => 'Fecha de compra ',
			'total' => 'Monto total',
			'observacion' => 'Observación',
			'usuario_id' => 'Usuario',
			'proveedor_id' => 'Proveedor',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('observacion',$this->observacion,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('usuario_id',$this->usuario_id);
		$criteria->compare('proveedor_id',$this->proveedor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TempCompra the static model class
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
        
        public function eliminar($idCompra) {
            $compra = $this->findByPk($idCompra);
            $compra->delete();
        }
}
