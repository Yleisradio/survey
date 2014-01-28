<?php

class ActivateButton extends NestableWidget
{
    public $survey;
    
    public function run()
    {
        $this->render('activateButton', array(
            'survey' => $this->survey,
                )
        );
        
    }

}
