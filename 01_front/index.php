<?php


$rootUrl = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path = explode('/',$rootUrl);

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('ROOT_PATH') or define('ROOT_PATH',dirname(__FILE__));

// change the following paths if necessary
$yii=ROOT_PATH.'/../03_library/yii.php';
$config = ROOT_PATH.'/protected/config/main.php';

require_once($yii);
Yii::createExtendWebApplication($config);
