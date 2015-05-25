<?php
/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @version $Id$
 * @package system
 * @since 1.0
 */

require(dirname(__FILE__).'/YiiBase.php');

/**
 * Yii is a helper class serving common framework functionalities.
 *
 * It encapsulates {@link YiiBase} which provides the actual implementation.
 * By writing your own Yii class, you can customize some functionalities of YiiBase.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @develop HieuNC <hieunc18@gmail.com>
 * @version $Id$
 * @package system
 * @since 1.0
 */
class Yii extends YiiBase
{
    private static $_extendApp;
    private static $_config_models_path;
    private static $_config_extension_path;

    public static function createExtendWebApplication($config = null)
    {
        self::$_extendApp = parent::createWebApplication($config);
//        self::$_config_extension_path= self::getPathOfAlias('rootPath.config.extensions');
        self::$_config_models_path= self::getPathOfAlias('application.config.models');
        try {
//            self::LoadModule();
            self::LoadModelsConfig();
        }catch (Exception $e){
            echo $e->getCode();
        }
        self::$_extendApp->run();
    }

    public static function LoadModule(){
//        Yii::app()->setComponents($config);
    }

    protected static function LoadModelsConfig(){
        Yii::app()->params['modelConfigPath'] = self::$_config_models_path.DIRECTORY_SEPARATOR;
    }


}
