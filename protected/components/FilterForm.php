<?php

class FilterForm extends CWidget
{
    public $filter;
    
    public function init()
    {
        
    }

    public function run()
    {
        $this->render('filterForm', array(
            'filter' => $this->filter,
        ));
    }

}