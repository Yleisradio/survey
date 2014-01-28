<?php

class NestableWidget extends CWidget
{

    private $content;

    public function __get($name)
    {

        if ($name === 'content')
            return $this->content;
        else
            return parent::__get($name);
    }

    public function render($view, $data = NULL, $return = false)
    {

        $this->content = parent::render($view, $data, true);
    }

}