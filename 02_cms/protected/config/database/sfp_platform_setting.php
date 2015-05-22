<?php

// This is the database connection configuration.
return array(
    'connectionString' => 'mysql:host=localhost;dbname=sfp_platform_setting',
    'emulatePrepare' => true,
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'initSQLs' => array("SET time_zone = '+07:00';"),
    'enableParamLogging' => true,
    'enableProfiling' => true,
    'schemaCachingDuration' => 3600,
    'class' => 'CDbConnection',
);