<?php

class m140520_044252_add_language_to_survey extends CDbMigration
{
    public function up()
    {
        $this->addColumn('survey', 'language', 'varchar(2) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('survey', 'language');
    }
}