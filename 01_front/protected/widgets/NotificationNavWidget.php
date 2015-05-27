<?php

class NotificationNavWidget extends CWidget
{
    public $view;
    private $data;

    public function init()
    {

    }

    public function run()
    {
        return $this->render($this->view);
    }
}
