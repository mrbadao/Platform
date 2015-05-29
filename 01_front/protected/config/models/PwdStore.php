
<?php

return array(
    'tableName' => 'pwd_store',
    'rules' => array(
            array('staff_id, value', 'required'),
            array('staff_id', 'numerical', 'integerOnly'=>true),
            array('role', 'length', 'max'=>45),
            array('value', 'length', 'max'=>128),
            array('created, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, staff_id, role, value, created, modified', 'safe', 'on'=>'search'),
    ),

    'relations' => array(
    ),

    'attributeLabels' => array(
            'id' => 'ID',
            'staff_id' => 'Staff',
            'role' => 'Role',
            'value' => 'Value',
            'created' => 'Created',
            'modified' => 'Modified',
    ),

);