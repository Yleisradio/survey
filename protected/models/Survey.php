<?php

/**
 * This is the model class for table "survey".
 *
 * The followings are the available columns in table 'survey':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $category
 * @property integer $frequency
 * @property string $comscore
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Answer[] $answers
 */
class Survey extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'survey';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, url, category, frequency, comscore', 'required'),
            array('frequency, active', 'numerical', 'integerOnly' => true),
            array('name, category, comscore', 'length', 'max' => 32),
            array('url', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, url, category, frequency, comscore, active', 'safe', 'on' => 'search'),
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
            'answers' => array(self::HAS_MANY, 'Answer', 'survey_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('admin', 'survey.name'),
            'url' => Yii::t('admin', 'survey.url'),
            'category' => Yii::t('admin', 'survey.category'),
            'frequency' => Yii::t('admin', 'survey.frequency'),
            'comscore' => Yii::t('admin', 'survey.comscore'),
            'active' => Yii::t('admin', 'survey.active'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('category', $this->category, true);
        $criteria->compare('frequency', $this->frequency);
        $criteria->compare('comscore', $this->comscore, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('deleted', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Survey the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Converts Survey to the format required by the YleWebPoll jQuery plugin
     * {"id":"136074972951621","siteTitle":"Areena","siteURL":"http://localhost/rullaava-kysely-test","freq":50,"category":"areenas","motivesList":"5.7.10.11.12.13.14.19.21.22.23","comScoreAccount":"areenas"}
     */
    public function toYleWebPollsConfigFormat()
    {
        $yleWebPollConfigFormat = array();
        $yleWebPollConfigFormat['id'] = $this->id;
        $yleWebPollConfigFormat['siteTitle'] = $this->name;
        $yleWebPollConfigFormat['siteURL'] = $this->url;
        $yleWebPollConfigFormat['category'] = $this->category;
        $yleWebPollConfigFormat['freq'] = $this->frequency;
        $yleWebPollConfigFormat['comScoreAccount'] = $this->comscore;
        //@TODO Fix motives list. Or remove it?
        $yleWebPollConfigFormat['motivesList'] = "5.7.10.11.12.13.14.19.21.22.23";
        return $yleWebPollConfigFormat;
    }

    /**
     * Soft delete
     * Prevents removing from database and changes the value of deleted to 1
     * @return boolean
     */
    protected function beforeDelete()
    {
        $this->deleted = 1;
        $this->save();
        return false;
    }

}
