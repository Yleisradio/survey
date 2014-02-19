<?php

class m140218_133444_add_sentiment_to_answer_topics extends CDbMigration
{
    public function up()
    {
        $this->addColumn('answer_topic', 'sentiment', 'float(3,1) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('answer_topic', 'sentiment');
    }

}