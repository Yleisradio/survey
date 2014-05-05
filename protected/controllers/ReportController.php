<?php

class ReportController extends Controller
{

    /**
     * @var string the default layout for the views. 
     */
    public $layout = 'report';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        if (Yii::app()->params['authentication']['required']) {
            return array(
                array('deny',
                    'users' => array('?'),
                ),
            );
        } else {
            return array();
        }
    }

    public function actionIndex()
    {

        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.time.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.resize.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.pie.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.categories.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.stack.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/moment-with-langs.min.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/data-loader.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/chart.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/underscore.min.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/masonry.min.js'));
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/report.css'));
        $this->render('index', array(
        ));
    }

}