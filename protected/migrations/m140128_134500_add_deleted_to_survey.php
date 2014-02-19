<?php

class m140128_134500_add_deleted_to_survey extends CDbMigration
{

    public function up()
    {
        $this->addColumn('survey', 'deleted', 'int(1) DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('survey', 'deleted');
    }

}