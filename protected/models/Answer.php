<?php

/**
 * This is the model class for table "answer".
 *
 * The followings are the available columns in table 'answer':
 * @property integer $id
 * @property integer $survey_id
 * @property integer $motive_id
 * @property integer $timestamp
 * @property string $motive_text
 * @property integer $success
 * @property string $failure_text
 * @property integer $recommend
 * @property integer $interest
 * @property string $feedback
 * @property integer $users
 * @property string $gender
 * @property integer $year_of_birth
 * @property double $sentiment
 * @property double $receipt
 * @property integer $analyzed
 * @property integer $analyze_started
 *
 * The followings are the available model relations:
 * @property Survey $survey
 */
class Answer extends QueryModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'answer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('timestamp', 'required'),
            array('survey_id, motive_id, timestamp, success, recommend, interest, users, year_of_birth, analyzed, analyze_started', 'numerical', 'integerOnly' => true),
            array('sentiment, receipt', 'numerical'),
            array('gender', 'length', 'max' => 6),
            array('motive_text, failure_text, feedback', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, survey_id, motive_id, timestamp, motive_text, success, failure_text, recommend, interest, feedback, users, gender, year_of_birth, sentiment, receipt, analyzed, analyze_started', 'safe', 'on' => 'search'),
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
            'survey' => array(self::BELONGS_TO, 'Survey', 'survey_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'survey_id' => 'Survey',
            'motive_id' => 'Motive',
            'timestamp' => 'Timestamp',
            'motive_text' => 'Motive Text',
            'success' => 'Success',
            'failure_text' => 'Failure Text',
            'recommend' => 'Recommend',
            'interest' => 'Interest',
            'feedback' => 'Feedback',
            'users' => 'Users',
            'gender' => 'Gender',
            'year_of_birth' => 'Year Of Birth',
            'sentiment' => 'Sentiment',
            'receipt' => 'Receipt',
            'analyzed' => 'Analyzed',
            'analyze_started' => 'Analyze Started',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('survey_id', $this->survey_id);
        $criteria->compare('motive_id', $this->motive_id);
        $criteria->compare('timestamp', $this->timestamp);
        $criteria->compare('motive_text', $this->motive_text, true);
        $criteria->compare('success', $this->success);
        $criteria->compare('failure_text', $this->failure_text, true);
        $criteria->compare('recommend', $this->recommend);
        $criteria->compare('interest', $this->interest);
        $criteria->compare('feedback', $this->feedback, true);
        $criteria->compare('users', $this->users);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('year_of_birth', $this->year_of_birth);
        $criteria->compare('sentiment', $this->sentiment);
        $criteria->compare('receipt', $this->receipt);
        $criteria->compare('analyzed', $this->analyzed);
        $criteria->compare('analyze_started', $this->analyze_started);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Answer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns the success rate in specified time range and survey grouped by specified interval
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $interval
     * @return type
     */
    public static function getSuccess($surveyId, $from, $to, $interval, $sitesTogether)
    {
        $sql = '
        SELECT ROUND(SUM(success) / SUM(total), 2) * 100 AS value, SUM(total) AS count, timestamp FROM (
            SELECT DISTINCT id, COUNT(id) AS success, COUNT(id) AS total, answer.timestamp FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE success = 1 AND ' . self::getWhereCondition($surveyId, $sitesTogether) . ' GROUP BY ' . self::getGroupBy($interval) . '
            UNION
            SELECT DISTINCT id, 0 AS success, COUNT(id) AS total, answer.timestamp FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE success = 0 AND ' . self::getWhereCondition($surveyId, $sitesTogether) . ' GROUP BY ' . self::getGroupBy($interval) . '
        ) AS success 
        GROUP BY ' . self::getGroupBy($interval, 'timestamp') . ' ORDER BY timestamp ASC
        ';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether));
        return $metrics;
    }

    /**
     * Returns the interest in specified time range and survey grouped by specified interval
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $interval
     * @return type
     */
    public static function getInterest($surveyId, $from, $to, $interval, $sitesTogether)
    {
        $sql = 'SELECT ROUND(AVG(interest), 2) AS value, COUNT(id) AS count, timestamp FROM (
                    SELECT DISTINCT ID, answer.interest, answer.timestamp FROM answer 
                    LEFT JOIN answer_topic ON answer_id = answer.id
                    WHERE interest IS NOT null AND ' . self::getWhereCondition($surveyId, $sitesTogether) . ') raw
                    GROUP BY ' . self::getGroupBy($interval, 'timestamp') . ' ORDER BY timestamp ASC';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether));
        return $metrics;
    }

    /**
     * Returns the net promoter score in specified time range and survey grouped by specified interval
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $interval
     * @return type
     */
    public static function getNPS($surveyId, $from, $to, $interval, $sitesTogether)
    {
        $sql = '
        SELECT ROUND(SUM(promoter) / SUM(count) - SUM(detractor) / SUM(count), 2) * 100 AS value, count, timestamp FROM (
            SELECT DISTINCT id, answer.timestamp, 1 AS promoter, 0 AS detractor, 0 AS count FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND recommend > 8 
            UNION
            SELECT DISTINCT id, answer.timestamp, 0 AS promoter, 1 AS detractor, 0 AS count FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND recommend < 7 
            UNION
            SELECT DISTINCT id, answer.timestamp, 0 AS promoter, 0 AS detractor, 1 AS count FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND recommend IS NOT null 
        ) AS nps GROUP BY ' . self::getGroupBy($interval, 'timestamp') . ' ORDER BY timestamp ASC
        ';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether));
        return $metrics;
    }

    /**
     * Returns the NPS in specified time range
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $db
     * @return type
     */
    public static function getTotalNPS($surveyId, $from, $to, $sitesTogether)
    {
        $sql = '
        SELECT ROUND(SUM(promoter) / SUM(count) - SUM(detractor) / SUM(count), 2) * 100 AS count FROM (
            SELECT DISTINCT id, 1 AS promoter, 0 AS detractor, 0 AS count FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND recommend > 8
            UNION
            SELECT DISTINCT id, 0 AS promoter, 1 AS detractor, 0 AS count FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND recommend < 7
            UNION
            SELECT DISTINCT id, 0 AS promoter, 0 AS detractor, 1 AS count FROM answer LEFT JOIN answer_topic ON answer_id = answer.id WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND recommend IS NOT null
        ) AS nps
        ';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether));
        return $metrics[0]['count'];
    }

    /**
     * Returns the sentiment in specified time range and survey grouped by specified interval
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $interval
     * @return type
     */
    public static function getSentiment($surveyId, $from, $to, $interval, $sitesTogether)
    {
        
        $sql = 'SELECT ROUND(AVG(sentiment), 2) AS value, timestamp, COUNT(id) AS count FROM (
                SELECT DISTINCT ID, answer.sentiment, answer.timestamp FROM answer 
                LEFT JOIN answer_topic ON answer_id = answer.id
                WHERE answer.sentiment IS NOT null AND ' . self::getWhereCondition($surveyId, $sitesTogether) . ') AS raw GROUP BY ' . self::getGroupBy($interval, 'timestamp') . 'ORDER BY timestamp ASC';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether));
        return $metrics;
    }

    /**
     * Returns the total number of answers in the specified time range and survey
     * @param type $sites
     * @param type $from
     * @param type $to
     * @param type $db
     * @return type
     */
    public static function getTotalN($surveyId, $from, $to, $sitesTogether)
    {
        $sql = 'SELECT COUNT(DISTINCT id) AS count FROM answer 
                LEFT JOIN answer_topic ON answer_id = answer.id
                WHERE ' . self::getWhereCondition($surveyId, $sitesTogether);
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether));
        return $metrics;
    }

    /**
     * Returns the number of answers in the specified time range, survey and gender
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $interval
     * @param type $gender
     * @return type
     */
    public static function getGender($surveyId, $from, $to, $interval, $gender, $sitesTogether)
    {
        $sql = 'SELECT 1 AS count, COUNT(DISTINCT id) AS value, answer.timestamp FROM answer
                LEFT JOIN answer_topic ON answer_id = answer.id
                WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND gender = :gender GROUP BY ' . self::getGroupBy($interval) . ' 
        ';
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether) + array(':gender' => $gender));
        return $metrics;
    }

    /**
     * Returns the number of answers in the specified time range, survey and age
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @param type $interval
     * @param type $startAge
     * @param type $endAge
     * @return type
     */
    public static function getAge($surveyId, $from, $to, $interval, $startAge, $endAge, $sitesTogether)
    {
        $year = date('Y');
        $sql = 'SELECT 1 AS count, COUNT(DISTINCT id) AS value, answer.timestamp FROM answer
                LEFT JOIN answer_topic ON answer_id = answer.id
            WHERE ' . self::getWhereCondition($surveyId, $sitesTogether) . ' AND year_of_birth <= :startAge AND year_of_birth > :endAge GROUP BY ' . self::getGroupBy($interval);
        $command = Yii::app()->db->createCommand($sql);
        $metrics = $command->queryAll(true, self::getWhereParams($surveyId, $from, $to, $sitesTogether) + array(
            ':startAge' => $year - $startAge,
            ':endAge' => $year - $endAge,
        ));
        return $metrics;
    }

    public static function getAnswers($surveyIds, $from, $to, $limit, $sitesTogether, $fromId)
    {
        if (intval($limit)) {
            $limit = intval($limit);
            
            $sql = 'SELECT DISTINCT answer.*, motive.motive, survey.name AS survey FROM answer 
                LEFT JOIN answer_topic ON answer_id = answer.id
                LEFT JOIN motive ON motive_id = motive.id 
                LEFT JOIN survey ON survey_id = survey.id
                WHERE' . self::getWhereCondition($surveyIds, $sitesTogether);
            $params = self::getWhereParams($surveyIds, $from, $to, $sitesTogether);
            if ($fromId) {
                $sql .= ' AND answer.id < :fromId';
                $params[':fromId'] = $fromId;
            }
            $sql .= ' ORDER BY timestamp DESC LIMIT ' . $limit;
            $command = Yii::app()->db->createCommand($sql);

            $answers = $command->queryAll(true, $params);

            foreach ($answers as &$answer) {
                $answer['age'] = null;
                if ($answer['year_of_birth']) {
                    $answer['age'] = date('Y', $answer['timestamp']) - $answer['year_of_birth'];
                }
                unset($answer['year_of_birth']);
                $answer['timestamp'] = date('c', $answer['timestamp']);
                unset($answer['receipt']);
                unset($answer['analyzed']);
                unset($answer['analyze_started']);
                unset($answer['motive_id']);
                if ($answer['motive_text']) {
                    $answer['motive'] = $answer['motive_text'];
                }
                unset($answer['motive_text']);
                $answer['group'] = self::getNPSGroup($answer['recommend']);
            }
            return $answers;
        } else {
            throw new CHttpException(400, 'Limit is not a number');
        }
    }

    public static function getNPSGroup($recommend)
    {
        if ($recommend <= 6) {
            return 'detractor';
        } else if ($recommend >= 9) {
            return 'promoter';
        } else {
            return 'neutral';
        }
    }

}
