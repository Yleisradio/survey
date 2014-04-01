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
                'title' => Yii::t('popup', 'title'),
                'text' => Yii::t('popup', 'text'), 
                'linkYes' => Yii::t('popup', 'yes'),
                'linkNo' => Yii::t('popup', 'no'),
                'formURL' => Yii::app()->createAbsoluteUrl('/form/form'),
                'categoryAttribute' => Yii::app()->params['categoryAttribute'],
            ),
        );
        foreach ($surveys as $survey) {
            $yleWebPollsConfig['continousPollList'][] = $survey->toYleWebPollsConfigFormat();
        }
        header('content-type: application/javascript');
        include('js/jquery.yle-webpoll.js');
        ?>var YLESurveyConfig=<?php
        echo json_encode($yleWebPollsConfig);
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
            //Clear motive text if a motive was chosen
            if ($answer->motive_id) {
                $answer->motive_text = null;
            }
            //Clear failure text if success
            if ($answer->success) {
                $answer->failure_text = null;
            }
            $answer->timestamp = time();
            $answer->survey_id = $surveyId;
            $answer->save();
            $this->redirect('thanks?id=' . Yii::app()->db->lastInsertId);
        } else {
            
        }
        $survey = Survey::model()->findByPk($surveyId);

        $this->render('form', array(
            'survey' => $survey,
            'answer' => $answer,
            'yearsOfBirth' => $yearsOfBirth,
        ));
    }

    public function actionThanks($id)
    {
        $answer = Answer::model()->findByPk($id);
        Yii::app()->clientScript->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css') . '/form.css'));
        $this->render('thanks', array(
            'answer' => $answer,
        ));
    }

}