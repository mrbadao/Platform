<?php

/**
 * Created by PhpStorm.
 * User: HieuNguyen
 * Date: 5/21/2015
 * Time: 3:57 PM
 */
defined('APP_ROOT_PATH') or define('APP_ROOT_PATH', substr(dirname(__FILE__), 0, -7) . DIRECTORY_SEPARATOR . 'protected');
defined('DB_FILE_EXT') or define('DB_FILE_EXT', '.sql');
defined('DB_SCHEMA_PREFIX') or define('DB_SCHEMA_PREFIX', 'schema.mysql.');
defined('DB_TABLE_PREFIX') or define('DB_TABLE_PREFIX', 'mysql.table.');
defined('MODULE_DEFAULT_ACCESS') or define('MODULE_DEFAULT_ACCESS', 'Common');

require_once(dirname(__FILE__) . "/DBConnection.php");

class BaseOnYiiWebApp
{
    private static $_aliases = array('system' => APP_ROOT_PATH);
    private $DEFAULT_SCHEMA_MYSQL = array(
        'connectionString' => 'mysql:host=localhost;dbname=mysql',
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

    private $config;
    private $CDbConnection;
    private $dbSchemaPath = 'system.data.';
    private $siteId;

    function __construct($config, $url = null)
    {
        if (is_string($config)) {
            $this->config = require_once($config);
        }

        $this->CDbConnection = new DBConnection($this->DEFAULT_SCHEMA_MYSQL);

        if($url){
            $path = explode('/', $url);
            if(isset($path[1])) {
                $this->siteId = self::_getSite($path[1]);
            }

            if(isset($path[0]) && $this->siteId == null){
                $this->siteId = self::_getSite($path[0]);
            }

            if($this->siteId == null) exit;
        }else{
            exit;
        }

        self::checkSchemas();
        self::Init($config);
    }

    private function _getSite($siteDomain){
        $query = 'SELECT * FROM sfp_platform.content_user_site where content_user_site.site_domain = ":site_domain";';
        $query = str_replace(':site_domain', $siteDomain, $query);

        $site = $this->CDbConnection->CreateCommand($query, true, true);
        if(!$site || isset($site['hasError'])) return null;
        return $site['id'];
    }

    private function checkSchemas()
    {
        $query = 'show databases;';
        $existsSchemas = $this->CDbConnection->CreateCommand($query, true);

        if (isset($existsSchemas['hasError'])) return false;

        $schemas_temp = array();
        foreach ($existsSchemas as $schema) {
            $schemas_temp[] = $schema['Database'];
        }

        $existsSchemas = $schemas_temp;
        $platformSchemas = self::getDatabaseSchemaFile();

        foreach ($platformSchemas as $schema) {
            if (!array_search($schema, $existsSchemas)) {
                self::installDataBase($schema);
            }
        }
    }

    private function getDatabaseSchemaFile()
    {
        $files = scandir(self::getPathOfAlias($this->dbSchemaPath));

        if ($files) {
            $schema = array();
            foreach ($files as $file) {
                if (substr($file, -4) == DB_FILE_EXT && substr($file, 0, strlen(DB_SCHEMA_PREFIX)) == DB_SCHEMA_PREFIX) {
                    $schema[] = substr($file, strlen(DB_SCHEMA_PREFIX), -4);
                }
            }
            return $schema;
        }
        return false;
    }

    private function getDatabaseTableFile($schema)
    {
        $files = scandir(self::getPathOfAlias($this->dbSchemaPath));
        $prefix = DB_TABLE_PREFIX . $schema . '.';
        if ($files) {
            $tables = array();
            foreach ($files as $file) {
                if (substr($file, -4) == DB_FILE_EXT && substr($file, 0, strlen($prefix)) == $prefix) {
                    $tables[] = substr($file, strlen($prefix), -4);
                }
            }
            return $tables;
        }
        return false;
    }

    public function patchDb($filename){
        $path = self::getPathOfAlias($this->dbSchemaPath) . DIRECTORY_SEPARATOR . 'dbpatch'. DIRECTORY_SEPARATOR . $filename . DB_FILE_EXT;
        $content = file_get_contents($path);
        $this->CDbConnection->CreateCommand($content);
    }

    private function installDataBase($schema)
    {
        $path = self::getPathOfAlias($this->dbSchemaPath) . DIRECTORY_SEPARATOR . DB_SCHEMA_PREFIX . $schema . DB_FILE_EXT;
        if (file_exists($path)) {
            $content = file_get_contents($path);

            $this->CDbConnection->CreateCommand($content);

            $tables = self::getDatabaseTableFile($schema);

            if (count($tables) < 1) return false;

            foreach ($tables as $table) {
                self::installTable($schema, $table);
            }
        }
    }

    private function installTable($schema, $tableName)
    {
        $path = self::getPathOfAlias($this->dbSchemaPath) . DIRECTORY_SEPARATOR . DB_TABLE_PREFIX . $schema . '.' . $tableName . DB_FILE_EXT;
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $this->CDbConnection->CreateCommand($content);
        }
    }

    protected function Init($config = null)
    {
        self::getComponents();
        self::getModules();
    }

    public function run()
    {
        return $this->config;
    }

    private function getComponents()
    {
        $components = self::_dbGetModule('component');
        $siteComponents = self::_dbGetModule('component', 'Limit');
        if($components) $this->config['components'] = array_merge($this->config['components'], $components);
        if($siteComponents) $this->config['components'] = array_merge($this->config['components'], $siteComponents);
    }

    private function _dbGetModule($type, $access = MODULE_DEFAULT_ACCESS){
        if($access == MODULE_DEFAULT_ACCESS) {
            $query = 'SELECT * FROM sfp_platform_setting.content_modules WHERE content_modules.module_type =":module_type" AND content_modules.module_access =":module_access";';
            $query = str_replace(':module_type', $type, $query);
            $query = str_replace(':module_access', $access, $query);
        }else{
            $query = 'SELECT sfp_platform_setting.content_modules.* FROM sfp_platform_setting.content_modules JOIN sfp_platform_setting.module_relation ON content_modules.id = module_relation.module_id WHERE module_relation.site_id = :site_id;';
            $query = str_replace(':site_id', $this->siteId, $query);
        }

        $modules =  $this->CDbConnection->CreateCommand($query, true);

        if($modules == null || isset($modules['hasError'])) return null;


        $result = array();

        foreach($modules as $module){
            $query = "SELECT * FROM sfp_platform_setting.content_module_attributes WHERE content_module_attributes.module_id = :module_id;";
            $query = str_replace(':module_id', $module['id'], $query);
            $paramsArr = $this->CDbConnection->CreateCommand($query, true);
            $params = array();

            foreach($paramsArr as $param){
                $params[$param['attr_name']] = $param['attr_value'];
            }

            $result[$module['module_name']] = $params;
        }
        return $result;
    }

    private function getModules()
    {

    }

    public static function getPathOfAlias($alias)
    {
        if (($pos = strpos($alias, '.')) !== false) {
            $rootAlias = substr($alias, 0, $pos);
            if (isset(self::$_aliases[$rootAlias]))
                return self::$_aliases[$alias] = rtrim(self::$_aliases[$rootAlias] . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, substr($alias, $pos + 1)), '*' . DIRECTORY_SEPARATOR);
        }
        return false;
    }
}
