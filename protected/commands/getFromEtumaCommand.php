<?php

class getFromEtumaCommand extends CConsoleCommand
{

    public function run($args)
    {
        $sql = 'SELECT * FROM answer WHERE analyze_started > :analyze_started AND analyzed IS null AND receipt IS NOT null LIMIT 10000';
        $command = Yii::app()->db->createCommand($sql);
        $answers = $command->queryAll(true, array(
            ':analyze_started' => time() - 24 * 60 * 60,
        ));

        foreach ($answers as $answer) {
            $data = array(
                'receipt' => $answer['receipt'],
            );

            $signal = Etuma::get('GetSignalAdvanced', $data);
            var_dump($signal);
            if (isset($signal['code'])) {
                if ($signal['code'] > 0) {

                    //Sentiment
                    $sql = 'UPDATE answer SET sentiment = :sentiment, analyzed = :analyzed WHERE id = :id';
                    $command = Yii::app()->db->createCommand($sql);
                    $answers = $command->execute(array(
                        ':sentiment' => $signal['ambiance'],
                        ':analyzed' => time(),
                        ':id' => $answer['id'],
                    ));

                    //Topics
                    foreach ($signal['topics'] as $topicArray) {
                        $topicArray = array_keys($topicArray);
                        $topicArray = $topicArray[0];

                        //Find topic ID
                        $sql = 'SELECT * FROM topic WHERE topic = :topic';
                        $command = Yii::app()->db->createCommand($sql);
                        $answers = $command->execute(array(
                            ':topic' => $topicArray,
                        ));

                        $topic = $statement->fetch();
                        $topicId = $topic['id'];

                        //Create topic if not found
                        if (!$topic) {
                            $sql = 'INSERT INTO topic (topic) VALUES (:topic)';
                            $command = Yii::app()->db->createCommand($sql);
                            $answers = $command->execute(array(
                                ':topic' => $topicArray,
                            ));

                            $topicId = Yii::app()->db->lastInsertId;
                        }

                        //Create relation to topic
                        $sql = 'INSERT INTO answer_topic (vastaus_id, topic_id, timestamp) VALUES (:vastaus_id, :topic_id, :timestamp)';
                        $command = Yii::app()->db->createCommand($sql);
                        $answers = $command->execute(array(
                            ':vastaus_id' => $answer['id'],
                            ':topic_id' => $topicId,
                            ':timestamp' => time(),
                        ));
                    }
                }
            }
        }
    }

}