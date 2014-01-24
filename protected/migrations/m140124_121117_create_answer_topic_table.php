<?php

class m140124_121117_create_answer_topic_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('answer_topic', array(
            'answer_id' => 'int(11) NOT NULL',
            'topic_id' => 'int(11) NOT NULL',
            'timestamp' => 'int(11) NOT NULL',
            'PRIMARY KEY (answer_id, topic_id)',
        ));
        $this->addForeignKey('answer', 'answer_topic', 'answer_id', 'answer', 'id', 'restrict', 'restrict');
        $this->addForeignKey('topic', 'answer_topic', 'topic_id', 'topic', 'id', 'restrict', 'restrict');
    }
    public function down()
    {
        $this->dropTable('answer_topic');
    }
}