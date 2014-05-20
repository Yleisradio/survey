<?php

class m140520_051624_add_language_to_motive extends CDbMigration
{
    public function up()
    {
        $this->addColumn('motive', 'language', 'varchar(2) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('motive', 'language');
    }
}