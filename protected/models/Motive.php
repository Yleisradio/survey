<?php

/**
 * This is the model class for table "motive".
 *
 * The followings are the available columns in table 'motive':
 * @property integer $id
 * @property string $motive
 *
 * The followings are the available model relations:
 * @property Survey[] $surveys
 */
class Motive extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'motive';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('motive', 'required'),
            array('language', 'length', 'max' => 2),
            array('id, motive', 'safe', 'on' => 'search'),
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
            'surveys' => array(self::MANY_MANY, 'Survey', 'motive_survey(motive_id, survey_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'motive' => Yii::t('admin', 'motive.motive'),
            'language' => Yii::t('admin', 'motive.language'),
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
        $criteria->compare('motive', $this->motive, true);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => 100,
            ),
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Motive the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeDelete()
    {
        MotiveSurvey::model()->deleteAllByAttributes(array(
            'motive_id' => $this->id,
        ));
        return parent::beforeDelete();
    }

    public static function getLanguages()
    {
        return array(
            'fi' => 'Finnish',
            'sv' => 'Swedish',
        );
    }
    
    public static function getMotives($language) {
        return Motive::model()->findAllByAttributes(array(
            'language' => $language,
        ));
    }

}
