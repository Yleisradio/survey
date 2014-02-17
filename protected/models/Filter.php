<?php

class Filter extends CFormModel
{

    const COMPARE_YEAR = 'year';
    const COMPARE_PERIOD = 'period';
    const COMPARE_NONE = 'none';

    public $surveys;
    public $from;
    public $to;
    public $mode;
    public $compare;

    public static function getCompares()
    {
        return array(
            self::COMPARE_NONE => Yii::t('report', 'compare.no'),
            self::COMPARE_YEAR => Yii::t('report', 'compare.year'),
            self::COMPARE_PERIOD => Yii::t('report', 'compare.period'),
        );
    }

    public function initFilter()
    {
        date_default_timezone_set("UTC");
        $this->from = date('c', strtotime('last week 00:00'));
        $this->to = date('c', strtotime('last week 00:00 + 6 days'));
        $this->mode = 'month';
        $this->setAttributes(Yii::app()->user->getState('Filter'), false);
    }

    public function saveFilter()
    {
        Yii::app()->user->setState('Filter', $this->attributes);
    }

    public function getFilterData()
    {
        $this->from = Yii::app()->request->getParam('from');
        $this->to = Yii::app()->request->getParam('to');
        $this->compare = Yii::app()->request->getParam('compare');
        $this->mode = Yii::app()->request->getParam('mode');
        $this->surveys = Yii::app()->request->getParam('surveys');
    }

}