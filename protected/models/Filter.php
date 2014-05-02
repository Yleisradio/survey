<?php

class Filter extends CFormModel
{

    const COMPARE_YEAR = 'year';
    const COMPARE_PERIOD = 'period';
    const COMPARE_NONE = 'none';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const AGE_0_14 = '0-14';
    const AGE_15_29 = '15-29';
    const AGE_30_44 = '30-44';
    const AGE_45_59 = '45-59';
    const AGE_60_74 = '60-74';
    const AGE_75 = '75+';

    public $surveys;
    public $from;
    public $to;
    public $mode;
    public $compare;
    public $gender;
    public $age;
    public $recommend_min;
    public $recommend_max;
    public $interest_min;
    public $interest_max;
    public $text_only;
    public $failed_only;

    public static function getCompares()
    {
        return array(
            self::COMPARE_NONE => Yii::t('report', 'compare.no'),
            self::COMPARE_YEAR => Yii::t('report', 'compare.year'),
            self::COMPARE_PERIOD => Yii::t('report', 'compare.period'),
        );
    }

    public static function getGenders()
    {
        return array(
            self::GENDER_MALE => Yii::t('report', 'male'),
            self::GENDER_FEMALE => Yii::t('report', 'female'),
        );
    }

    public static function getAges()
    {
        return array(
            self::AGE_0_14 => '0-14',
            self::AGE_15_29 => '15-29',
            self::AGE_30_44 => '30-44',
            self::AGE_45_59 => '45-59',
            self::AGE_60_74 => '60-74',
            self::AGE_75 => '75+',
        );
    }

    public function initFilter()
    {
        date_default_timezone_set("UTC");
        $this->from = date('c', strtotime('this week 00:00'));
        $this->to = date('c', strtotime('last week 00:00 + 6 days'));
        $this->surveys = array_values(CHtml::listData(Survey::model()->findAll(), 'category', 'category'));
        $this->mode = 'week';
        $this->setAttributes(Yii::app()->user->getState('Filter'), false);
    }

    public function saveFilter()
    {
        Yii::app()->user->setState('Filter', $this->attributes);
    }

    public function getFilterData()
    {
        $this->setAttributes($_GET, false);
        var_dump($this->attributes);
    }

}