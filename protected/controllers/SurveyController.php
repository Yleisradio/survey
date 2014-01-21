<?php

class SurveyController extends Controller
{

    public function actionForm($surveyId)
    {
        $survey = Survey::model()->findByPk($surveyId);
        $this->render('form', array(
            'survey' => $survey,
        ));
    }

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
        include('js/jquery.yle-webpropoll.js');
        ?>var YLEWebPollsConfig=<?php
        echo json_encode($yleWebPollsConfig, JSON_UNESCAPED_SLASHES);
    }

}