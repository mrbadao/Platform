
<?php

return array(
    'tableName' => 'staff',
    'rules' => array(
            array('login_id, password, profile_image, name, address, phone, email', 'required'),
            array('cms_theme_id, front_theme_id', 'numerical', 'integerOnly'=>true),
            array('login_id', 'length', 'max'=>45),
            array('password, profile_image, name, phone, email', 'length', 'max'=>128),
            array('created, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, login_id, password, profile_image, name, address, phone, email, cms_theme_id, front_theme_id, created, modified', 'safe', 'on'=>'search'),
    ),

    'relations' => array(
    ),

    'attributeLabels' => array(
            'id' => 'ID',
            'login_id' => 'Login',
            'password' => 'Password',
            'profile_image' => 'Profile Image',
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'cms_theme_id' => 'Cms Theme',
            'front_theme_id' => 'Front Theme',
            'created' => 'Created',
            'modified' => 'Modified',
    ),

);