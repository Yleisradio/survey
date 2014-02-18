<?php

class sendToEtumaCommand extends CConsoleCommand
{

    public function run($args)
    {
        $sql = 'SELECT answer.*, survey.name AS survey FROM answer
            LEFT JOIN survey ON answer.survey_id = survey.id
            WHERE receipt IS null AND (feedback != "" OR failure_text != "") 
            ORDER BY timestamp DESC 
            LIMIT 10';
        $command = Yii::app()->db->createCommand($sql);
        $answers = $command->queryAll();

        $data = array(
            'signals' => array(),
            'subsignalformid' => Yii::app()->params['etuma']['subsignalformid'],
        );

        foreach ($answers as $answer) {
            $data['signals'][] = array(
                'heading' => $answer['failure_text'],
                'body' => $answer['feedback'],
                'backgroundvariables' => array(
                    'syntymävuosi=' . $answer['year_of_birth'],
                    'CXDATE=' . date('Y-m-d', $answer['timestamp']) . 'T' . date('H:i:s', $answer['timestamp']) . 'Z',
                    'onnistuminen=' . $answer['success'],
                    'suosittelu=' . $answer['recommend'],
                    'kiinnostavuus=' . $answer['interest'],
                    'kuinkamonikoneella=' . $answer['users'],
                    'sukupuoli=' . $answer['gender'],
                    'sivusto=' . $answer['survey'],
                ),
            );
        }
        $signal = Etuma::post('AddSignals', $data);

        var_dump($signal);
        
        $i = 0;
        foreach ($answers as $answer) {
            $sql = 'UPDATE answer SET analyze_started = :analyze_started, receipt = :receipt WHERE id = :id';
            $command = Yii::app()->db->createCommand($sql);
            $answers = $command->execute(array(
                ':receipt' => $signal['receipts'][$i],
                ':analyze_started' => time(),
                ':id' => $answer['id'],
            ));
            $i++;
        }
    }

}