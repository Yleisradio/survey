<?php

class importSurveysFromSurvey2Command extends CConsoleCommand
{

    public function run($args)
    {
        $data = file_get_contents('data/sites.json');
        $surveys = CJSON::decode($data, true);
        $surveys = $surveys['sites'];
        foreach ($surveys as $survey) {
            $surveyObject = new Survey();
            $surveyObject->name = $survey['siteTitle'];
            $surveyObject->url = $survey['siteURL'];
            if ($survey['siteStatus']) {
                $surveyObject->active = 1;
            } else {
                $surveyObject->active = 0;
            }
            $surveyObject->frequency = $survey['freq'];
            $surveyObject->category = $survey['category'];
            $surveyObject->comscore = $survey['comScoreAccount'];
            $surveyObject->deleted = 0;
            $surveyObject->save();
            $surveyObject->id = Yii::app()->db->lastInsertId;
            $motives = explode('.', $survey['motivesList']);
            foreach ($motives as $motive) {
                $motiveSurvey = new MotiveSurvey();
                $motiveSurvey->motive_id = $motive;
                $motiveSurvey->survey_id = $surveyObject->id;
                $motiveSurvey->save();
            }
        }
    }

}