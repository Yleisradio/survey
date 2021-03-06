<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/base';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * HTML title of the page
     * @var string 
     */
    public $title;

    public function beforeAction($action)
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css'));
        $cs->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/bootstrap.js'));
        parent::beforeAction($action);
        return true;
    }

    protected function getHeader()
    {
        $yleAnalyticsHeader = Yii::app()->cache->get('yle-analytics-header');
        if (!$yleAnalyticsHeader) {
            $yleAnalyticsHeader = Curl::get('http://localhost/verkkoanalytiikka/site/header', array(), array('httpProxy' => null));
            if (strstr($yleAnalyticsHeader, 'Error 404') === false) {
                Yii::app()->cache->set('yle-analytics-header', $yleAnalyticsHeader, 30 * 60);
                Yii::app()->cache->set('yle-analytics-header-backup', $yleAnalyticsHeader, 24 * 60 * 60);
            } else {
                $yleAnalyticsHeader = Yii::app()->cache->get('yle-analytics-header-backup');
                if (!$yleAnalyticsHeader) {
                    $yleAnalyticsHeader = '';
                }
            }
        }
        Yii::app()->clientScript->registerCssFile('http://data.yle.fi/verkkoanalytiikka/css/header.css');
        return $yleAnalyticsHeader;
    }
}
