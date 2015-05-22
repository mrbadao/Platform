<?php

class SiteUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        $paths = explode('/', rtrim($pathInfo, '/'));

        if(count($paths > 0)){
            $site = ContentUserSite::model()->findByAttributes(array('site_domain' => $paths[0]));
            if($site) return 'site/index';
        }

        $siteDomain = str_replace('https://','', Yii::app()->request->getBaseUrl(true));
        $siteDomain = str_replace('http://','', $siteDomain);

        $site = ContentUserSite::model()->findByAttributes(array('site_domain' => $siteDomain));
        if($site) return 'site/index';

        return FALSE;
    }

}
