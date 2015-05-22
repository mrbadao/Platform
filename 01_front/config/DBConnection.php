<?php

/**
 * Created by PhpStorm.
 * User: HieuNguyen
 * Date: 5/22/2015
 * Time: 8:29 AM
 */
class DBConnection
{


    public $username = 'root';
    public $password = '';
    public $connectionString = '';
    public $_handle;
    public $_charset = 'utf8';

    function __construct($db)
    {
        $this->username = $db['username'];
        $this->password = $db['password'];
        $this->connectionString = $db['connectionString'];
        $this->connectionString = isset($db['charset']) ? $this->connectionString . ';charset' . $db['charset'] : $this->connectionString;
    }

    function active()
    {
        try {
            $this->_handle = new PDO($this->connectionString, $this->username, $this->password);
            $this->_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function CreateCommand($query = null, $getResult = null, $is_fetch = false)
    {
        if (!$this->_handle) $this->active();
        try {
            $stmt = $this->_handle->query($query);
            if($getResult != null){
                if($is_fetch) return $stmt->fetch();
                return $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            return array('hasError' => true, 'code' => $e->getCode(), 'message' => $e->getMessage());
        }
    }

}

