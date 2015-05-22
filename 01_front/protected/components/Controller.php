<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    const SESS_KEY = '_SITEID';
    public $siteId;
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init()
    {
        $session = Yii::app()->session;

        if($session->contains(self::SESS_KEY)){
            $this->siteId = Yii::app()->session[self::SESS_KEY];
            $theme = ContentThemes::model()->findByPk($this->siteId);
            Yii::app()->theme = $theme->theme_domain;
        }else Yii::app()->end();

        if (Yii::app()->params['requireSSL'] && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")) {
            $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $redirect");
        }
    }

    public function render($view, $data = null, $return = false)
    {
        if ($this->beforeRender($view)) {
            $output = $this->renderPartial($view, $data, true);
            if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
                if (!is_array($data)) {
                    $output = $this->renderFile($layoutFile, array('content' => $output), true);
                } else {
                    $output = $this->renderFile($layoutFile, array_merge(array('content' => $output), $data), true);
                }

            $this->afterRender($view, $output);

            $output = $this->processOutput($output);

            if ($return)
                return $output;
            else
                echo $output;
        }
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}
