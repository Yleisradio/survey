<?php

class m140129_133627_create_motive_survey_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('motive_survey', array(
            'motive_id' => 'int(11) NOT NULL',
            'survey_id' => 'int(11) NOT NULL',
            'PRIMARY KEY (motive_id, survey_id)',
        ));
        $this->addForeignKey('motive', 'motive_survey', 'motive_id', 'motive', 'id', 'restrict', 'restrict');
        $this->addForeignKey('survey', 'motive_survey', 'survey_id', 'survey', 'id', 'restrict', 'restrict');
    }
    public function down()
    {
        $this->dropTable('answer_topic');
    }
}