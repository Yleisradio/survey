<?php

class ReportController extends Controller
{
    public function actionIndex() {

        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.time.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js.flot') . '/jquery.flot.resize.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/moment-with-langs.min.js'));
        Yii::app()->clientScript->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.js') . '/data-loader.js'));
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/report.css'));
        $this->render('index', array(

        ));
    }
}