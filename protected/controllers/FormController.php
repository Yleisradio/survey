<?php

class FormController extends Controller
{

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

    /**
     * Displays and processes the survey form
     * @param integer $surveyId
     */
    public function actionForm($surveyId)
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/form.css'));

        //Generate possible birth years to the dropdown menu
        $yearsOfBirth = array(
            '' => Yii::t('form', 'choose'),
        );
        for ($yearOfBirth = (date('Y') - 5); $yearOfBirth >= 1900; $yearOfBirth--) {
            $yearsOfBirth[$yearOfBirth] = $yearOfBirth;
        }

        $answer = new Answer();
        if (Yii::app()->request->isPostRequest) {
            $answer->attributes = $_POST['Answer'];
            $answer->timestamp = time();
            $answer->survey_id = $surveyId;
            $answer->save();
            $this->redirect('thanks');
        } else {
            
        }
        $survey = Survey::model()->findByPk($surveyId);

        $this->render('form', array(
            'survey' => $survey,
            'answer' => $answer,
            'yearsOfBirth' => $yearsOfBirth,
        ));
    }

    public function actionThanks()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/form.css'));
        $this->render('thanks');
    }

}