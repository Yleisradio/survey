<?php

class FilterForm extends CWidget
{

    public $filter;

    public function init()
    {
        if (!$this->filter) {
            $this->filter = new Filter;
        }

        $this->filter->initFilter();
    }

    public function run()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.components.js') . '/filter.js'));

        $this->render('filterForm', array(
            'filter' => $this->filter,
        ));
    }

}