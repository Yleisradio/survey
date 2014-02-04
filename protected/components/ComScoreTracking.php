<?php

class ComScoreTracking extends CWidget
{

    public $path;
    protected $url;

    public function init()
    {
        $this->url =  Yii::app()->params['comScore']['baseUrl'] . $this->path;
    }

    public function run()
    {
        if ($this->path && Yii::app()->params['comScore']['baseUrl']) {
            Yii::app()->clientScript->registerScriptFile('http://yle.fi/global/sitestat/sitestat.min.js', CClientScript::POS_END);
            $this->render('comScoreTracking');
        }
    }

}