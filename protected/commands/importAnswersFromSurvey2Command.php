<?php

class importAnswersFromSurvey2Command extends CConsoleCommand
{

    public function run($args)
    {
        $command = Yii::app()->db_old->createCommand('SELECT * FROM vastaukset');
        $dataReader = $command->query();
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($dataReader as $answer) {                
                $answerObject = new Answer();   
                $survey = Survey::model()->findByAttributes(array('name' => html_entity_decode($answer['sivusto'])));
                if (!$survey) {
                    var_dump('Survey not found: ' . html_entity_decode($answer['sivusto']));
                } else {
                    $answerObject->survey_id = $survey->id;
                    $answerObject->motive_id = ($answer['motiivi'] + 1);
                    $answerObject->timestamp = $answer['timestamp'];
                    $answerObject->motive_text = html_entity_decode($answer['motiivi_other']);
                    $answerObject->success = $answer['onnistuminen'];
                    $answerObject->failure_text = html_entity_decode($answer['miksiei']);
                    $answerObject->recommend = $answer['suosittelu'];
                    $answerObject->interest = $answer['kiinnostavuus'];
                    $answerObject->feedback = html_entity_decode($answer['muutapalautetta']);
                    $answerObject->users = $answer['kuinkamonikoneella'];
                    if ($answer['sukupuoli'] === '1') {
                        $answerObject->gender = 'male';
                    } else if ($answer['sukupuoli'] === '0') {
                        $answerObject->gender = 'female';
                    }
                    $answerObject->year_of_birth = $answer['syntymavuosi'];
                    $answerObject->save();
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw new Exception($e);
        }
    }

}