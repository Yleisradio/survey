<?php

class m140120_130154_create_answer_table extends CDbMigration
{

    public function up()
    {
        $this->createTable('answer', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'survey_id' => 'int(11) DEFAULT NULL',
            'motive_id' => 'int(11) DEFAULT NULL',
            'timestamp' => 'int(11) NOT NULL',
            'motive_text' => 'text DEFAULT NULL',
            'success' => 'int(1) DEFAULT NULL',
            'failure_text' => 'text DEFAULT NULL',
            'recommend' => 'int(2) DEFAULT NULL',
            'interest' => 'int(1) DEFAULT NULL',
            'feedback' => 'text DEFAULT NULL',
            'users' => 'int(1) DEFAULT NULL',
            'gender' => 'enum("male", "female") DEFAULT NULL',
            'year_of_birth' => 'int(4) DEFAULT NULL',
            'PRIMARY KEY (id)',
            'KEY `survey_id` (`survey_id`)',
            'KEY `motive_id` (`motive_id`)',
        ));
        $this->addForeignKey('survey', 'answer', 'survey_id', 'survey', 'id', 'restrict', 'restrict');
    }

    public function down()
    {
        $this->dropTable('answer');
    }

}