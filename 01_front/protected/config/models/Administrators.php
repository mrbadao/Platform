
<?php

return array(
    'tableName' => 'administrators',
    'rules' => array(
            array('login_id, password, name, address, email, phone', 'required'),
            array('is_super, front_theme_id, cms_theme_id', 'numerical', 'integerOnly'=>true),
            array('login_id', 'length', 'max'=>45),
            array('password, name, email', 'length', 'max'=>128),
            array('phone', 'length', 'max'=>15),
            array('created, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, login_id, password, is_super, name, address, email, phone, front_theme_id, cms_theme_id, created, modified', 'safe', 'on'=>'search'),
    ),

    'relations' => array(
    ),

    'attributeLabels' => array(
            'id' => 'ID',
            'login_id' => 'Login',
            'password' => 'Password',
            'is_super' => 'Is Super',
            'name' => 'Name',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone',
            'front_theme_id' => 'Front Theme',
            'cms_theme_id' => 'Cms Theme',
            'created' => 'Created',
            'modified' => 'Modified',
    ),

);