<?php

class m140226_084207_change_url_and_category_to_not_mandatory extends CDbMigration
{
	public function up()
	{
            $this->alterColumn('survey', 'url', 'varchar(128) DEFAULT NULL');
            $this->alterColumn('survey', 'url', 'varchar(32) DEFAULT NULL');
	}

	public function down()
	{
		echo "m140226_084207_change_url_and_category_to_not_mandatory does not support migration down.\n";
		return false;
	}

}