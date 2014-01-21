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
class Answer extends CActiveRecord
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
			array('survey_id, motive_id, timestamp, success, recommend, interest, users, year_of_birth, analyzed, analyze_started', 'numerical', 'integerOnly'=>true),
			array('sentiment, receipt', 'numerical'),
			array('gender', 'length', 'max'=>6),
			array('motive_text, failure_text, feedback', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, survey_id, motive_id, timestamp, motive_text, success, failure_text, recommend, interest, feedback, users, gender, year_of_birth, sentiment, receipt, analyzed, analyze_started', 'safe', 'on'=>'search'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('survey_id',$this->survey_id);
		$criteria->compare('motive_id',$this->motive_id);
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('motive_text',$this->motive_text,true);
		$criteria->compare('success',$this->success);
		$criteria->compare('failure_text',$this->failure_text,true);
		$criteria->compare('recommend',$this->recommend);
		$criteria->compare('interest',$this->interest);
		$criteria->compare('feedback',$this->feedback,true);
		$criteria->compare('users',$this->users);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('year_of_birth',$this->year_of_birth);
		$criteria->compare('sentiment',$this->sentiment);
		$criteria->compare('receipt',$this->receipt);
		$criteria->compare('analyzed',$this->analyzed);
		$criteria->compare('analyze_started',$this->analyze_started);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Answer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
