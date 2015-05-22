<?php


// change the following paths if necessary
$yii=dirname(__FILE__).'/../03_library/yii.php';
$app=dirname(__FILE__).'/config/init.php';
$rootUrl = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$path = explode('/',$rootUrl);

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($app);


$webApp= new BaseOnYiiWebApp(dirname(__FILE__).'/protected/config/main.php',$rootUrl);
//$webApp->patchDb('mysql.table.sfp_platform.content_themes');
$app = Yii::createWebApplication($webApp->run());

//$app->run();
