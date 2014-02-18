<?php

class importMotivesFromSurvey2Command extends CConsoleCommand
{

    public function run($args)
    {
        $data = file_get_contents('data/motives.json');
        $motives = CJSON::decode($data, true);
        foreach($motives as $motive) {
            $motiveObject = new Motive();
            $motiveObject->motive = $motive;
            $motiveObject->save();
        }
    }

}