<?php

class QuickEmailWidget extends CWidget
{
    public $controllAction;
    public function init()
    {

    }

    public function run()
    {
        $controllAction = $this->controllAction;
        return $this->render('index-quick-email', compact('controllAction'));
    }
}
