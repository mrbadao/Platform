<?php

class AdminControllerUrlRule extends CBaseUrlRule
{

    public function createUrl($manager, $route, $params, $ampersand)
    {
        switch($route) {
            case 'admin/index':
                return 'admin/';
            case 'admin/login':
                return 'admin/login.html';
            case 'admin/logout':
                return 'admin/logout.html';
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if($paths[0] != 'admin') return false;
        if(!isset($paths[1])) return 'admin/index';

        switch($paths[1]) {
            case 'index.html':
                return 'admin/index';
            case 'login.html':
                return 'admin/login';
            case 'logout.html':
                return 'admin/logout';
        }

        return FALSE;
    }

}
