<?php

class m140428_094909_add_updated_to_survey extends CDbMigration
{

    public function up()
    {
        $this->addColumn('survey', 'updated', 'int(11) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('survey', 'updated');
    }

}
