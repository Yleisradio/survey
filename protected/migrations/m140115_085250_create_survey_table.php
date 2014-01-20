<?php

class m140115_085250_create_survey_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('survey', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'name' => 'varchar(32) NOT NULL',
            'url' => 'varchar(128) NOT NULL',
            'category' => 'varchar(32) NOT NULL',
            'frequency' => 'int(3) NOT NULL',
            'comscore' => 'varchar(32) NOT NULL',
            'PRIMARY KEY (id)',
            'KEY `category` (`category`)',
            'KEY `url` (`url`)',
        ));
    }

    public function down()
    {
        $this->dropTable('survey');
    }

}