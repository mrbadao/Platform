<?php

/**
 * This is the model class for table "pwd_store".
 *
 * The followings are the available columns in table 'pwd_store':
 * @property integer $id
 * @property integer $staff_id
 * @property string $role
 * @property string $value
 * @property string $created
 * @property string $modified
 */
class PwdStore extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PwdStore the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
        return self::getConfig('tableName');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return self::getConfig('rules');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        return self::getConfig('relations');
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return self::getConfig('attributeLabels');
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('staff_id',$this->staff_id);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    private function getConfig($name){
        $config = require_once(Yii::app()->params['modelConfigPath'].__CLASS__.'.php');
        return !isset($config[$name]) || empty($config[$name]) ? array() : $config[$name];
    }
}