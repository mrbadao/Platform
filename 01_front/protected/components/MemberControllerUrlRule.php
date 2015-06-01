<?php

class MemberControllerUrlRule extends CBaseUrlRule
{

    public function createUrl($manager, $route, $params, $ampersand)
    {
        switch($route) {
            case 'member/index':
                return 'member/';
            case 'member/login':
                return 'member/login.html';
            case 'member/logout':
                return 'member/logout.html';
        }
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if($paths[0] != 'member') return false;
        if(!isset($paths[1])) return 'member/index';

        switch($paths[1]) {
            case 'index.html':
                return 'member/index';
            case 'login.html':
                return 'member/login';
            case 'logout.html':
                return 'member/logout';
        }
        return FALSE;
    }

}
