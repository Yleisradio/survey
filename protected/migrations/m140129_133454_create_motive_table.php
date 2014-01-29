<?php

class m140129_133454_create_motive_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('motive', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'motive' => 'text NOT NULL',
            'PRIMARY KEY (id)',
        ));
    }

    public function down()
    {
        $this->dropTable('motive');
    }
}