<?php

/**
 * This is the model class for table "staff".
 *
 * The followings are the available columns in table 'staff':
 * @property integer $id
 * @property string $login_id
 * @property string $password
 * @property string $profile_image
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $cms_theme_id
 * @property integer $front_theme_id
 * @property string $created
 * @property string $modified
 */
class Staff extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Staff the static model class
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
		$criteria->compare('login_id',$this->login_id,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('cms_theme_id',$this->cms_theme_id);
		$criteria->compare('front_theme_id',$this->front_theme_id);
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

    public function hashPassword($pwd){
        return md5($pwd);
    }
}