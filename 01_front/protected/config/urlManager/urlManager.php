<?php
/**
 * Created by PhpStorm.
 * User: HieuNguyen
 * Date: 5/18/2015
 * Time: 5:33 PM
 */
return array(
    'urlFormat'=>'path',
    'showScriptName' => false,
    'rules'=>array(
        'gii'=>'gii',
        'gii/<controller:\w+>'=>'gii/<controller>',
        'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
        array(
            'class' => 'application.components.AdminControllerUrlRule',
        ),
        array(
            'class' => 'application.components.MemberControllerUrlRule',
        ),
        '<module:\w+>/<action:\w+>'=>'<module>/default/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
//        '<action:\w+>'=>'site/<action>',
//        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

    ),
);