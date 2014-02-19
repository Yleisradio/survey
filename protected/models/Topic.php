<?php

/**
 * This is the model class for table "topic".
 *
 * The followings are the available columns in table 'topic':
 * @property integer $id
 * @property string $topic
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 */
class Topic extends QueryModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'topic';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('topic', 'required'),
            array('topic', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, topic', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answers' => array(self::MANY_MANY, 'Answer', 'answer_topic(topic_id, answer_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'topic' => 'Topic',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Topic the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getTopics($surveyIds, $from, $to, $limit, $sitesTogether)
    {
        if (intval($limit)) {
            $limit = intval($limit);
            $sql = 'SELECT topic, SUM(negative) AS negative, SUM(neutral) AS neutral, SUM(positive) AS positive, SUM(negative + neutral + positive) AS total  FROM (   
        SELECT topic.topic, answer.id, 1 AS negative, 0 AS neutral, 0 AS positive FROM topic 
        LEFT JOIN answer_topic ON answer_topic.topic_id = topic.id 
        LEFT JOIN answer ON answer_id = answer.id
        LEFT JOIN survey ON survey_id = answer.survey_id
        WHERE answer_topic.sentiment <= -0.5 AND ' . self::getWhereCondition($surveyIds, $sitesTogether) . '
        GROUP BY topic.id, answer.id
        UNION
        SELECT topic.topic, answer.id, 0 AS negative,  1 AS neutral, 0 AS positive FROM topic 
        LEFT JOIN answer_topic ON answer_topic.topic_id = topic.id
        LEFT JOIN answer ON answer_id = answer.id
        LEFT JOIN survey ON survey_id = answer.survey_id
        WHERE answer_topic.sentiment > -0.5 AND answer_topic.sentiment < 0.5 AND ' . self::getWhereCondition($surveyIds, $sitesTogether) . '
        GROUP BY topic.id, answer.id
        UNION
        SELECT topic.topic, answer.id,  0 AS negative, 0 AS neutral,  1 AS positive FROM topic 
        LEFT JOIN answer_topic ON answer_topic.topic_id = topic.id
        LEFT JOIN answer ON answer_id = answer.id
        LEFT JOIN survey ON survey_id = answer.survey_id
        WHERE answer_topic.sentiment >= 0.5 AND ' . self::getWhereCondition($surveyIds, $sitesTogether) . '
        GROUP BY topic.id, answer.id) AS sentiments
        GROUP BY topic
        ORDER BY total DESC ';
            $sql .=  'LIMIT ' . $limit;

            $command = Yii::app()->db->createCommand($sql);
            $params = self::getWhereParams($surveyIds, $from, $to, $sitesTogether);

            $topics = $command->queryAll(true, $params);

            foreach ($topics as &$topic) {
                
            }
            return $topics;
        } else {
            throw new CHttpException(400, 'Limit is not a number');
        }
    }

}
