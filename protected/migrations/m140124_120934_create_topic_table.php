<?php

class m140124_120934_create_topic_table extends CDbMigration
{

    public function up()
    {
        $this->createTable('topic', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'topic' => 'varchar(32) NOT NULL',
            'PRIMARY KEY (id)',
            'KEY `topic` (topic)',
        ));
    }

    public function down()
    {
        $this->dropTable('topic');
    }

}