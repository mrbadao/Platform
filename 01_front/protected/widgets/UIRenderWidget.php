<?php

class UIRenderWidget extends CWidget
{
    public $view;
    public $children = array();
    private $data;

    public function init()
    {
        foreach ($this->children as $children) {
            if (isset($children['type']) && $children['type'] == 'widget')
                $this->data[$children['class']] = $this->widget($children['class'], array('view' => $children['view']), true);
        }
    }

    public function run()
    {
        $data = $this->data;
        return $this->render($this->view, compact('data'));
    }
}
