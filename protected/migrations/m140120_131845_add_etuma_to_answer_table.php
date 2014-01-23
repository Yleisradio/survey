<?php

class m140120_131845_add_etuma_to_answer_table extends CDbMigration
{
    public function up()
    {
        $this->addColumn('answer', 'sentiment', 'float(3,1) DEFAULT NULL');
        $this->addColumn('answer', 'receipt', 'varchart(44) DEFAULT NULL');
        $this->addColumn('answer', 'analyzed', 'int(11) DEFAULT NULL');
        $this->addColumn('answer', 'analyze_started', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('answer', 'sentiment');
        $this->dropColumn('answer', 'receipt');
        $this->dropColumn('answer', 'analyzed');
        $this->dropColumn('answer', 'analyze_started');
    }
}