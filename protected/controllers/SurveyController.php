<?php

class SurveyController extends Controller
{

    public function actionForm($surveyId)
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/form.css'));
        
        $dateOfBirthYears = array();
        for($dateOfBirthYear = (date('Y') - 5); $dateOfBirthYear >= 1900; $dateOfBirthYear--) {
            $dateOfBirthYears[] = $dateOfBirthYear;
        }
        
        $survey = Survey::model()->findByPk($surveyId);
        $answer = new Answer();
        $this->render('form', array(
            'survey' => $survey,
            'answer' => $answer,
            'dateOfBirthYears' => $dateOfBirthYears,
        ));
    }
    
    /**
     * Returns YleWebPoll jQuery plugin and the survey configs for the plugin
     */
    public function actionSurveys()
    {
        $surveys = Survey::model()->findAllByAttributes(array('active' => 1));
        $yleWebPollsConfig = array(
            'continousPollList' => array(),
            'continousPollConf' => array(
                'formURL' => 'http://localhost/survey/survey/form',
            ),
        );
        foreach ($surveys as $survey) {
            $yleWebPollsConfig['continousPollList'][] = $survey->toYleWebPollsConfigFormat();
        }
        header('content-type: application/javascript');
        include('js/jquery.yle-webpoll.js');
        ?>var YLEWebPollsConfig=<?php
        echo json_encode($yleWebPollsConfig, JSON_UNESCAPED_SLASHES);
    }

}