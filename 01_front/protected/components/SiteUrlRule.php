<?php

class SiteUrlRule extends CBaseUrlRule
{
    const SESS_KEY = '_SITEID';
    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand)
    {

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $paths = explode('/', rtrim($pathInfo, '/'));
        $session = Yii::app()->session;

        if (count($paths > 0)) {
            $site = ContentUserSite::model()->findByAttributes(array('site_domain' => $paths[0]));
            if ($site) {
                $session->remove(self::SESS_KEY);
                $session->add(self::SESS_KEY, $site->id);
                return 'site/index';
            }
        }

        $siteDomain = str_replace('https://', '', Yii::app()->request->getBaseUrl(true));
        $siteDomain = str_replace('http://', '', $siteDomain);

        $site = ContentUserSite::model()->findByAttributes(array('site_domain' => $siteDomain));
        if ($site) {
            $session->remove(self::SESS_KEY);
            $session->add(self::SESS_KEY, $site->id);
            return 'site/index';
        }

        return FALSE;
    }

}
