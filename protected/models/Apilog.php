<?php

/**
 * This is the model class for table "apilog".
 *
 * The followings are the available columns in table 'apilog':
 * @property integer $id
 * @property integer $service
 * @property integer $timestamp
 * @property string $request
 * @property string $response
 */
class Apilog extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'apilog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request, timestamp', 'required'),
            array('timestamp', 'numerical', 'integerOnly' => true),
            array('response', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, timestamp, request, response', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'timestamp' => 'Timestamp',
            'request' => 'Request',
            'response' => 'Response',
        );
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Apilog the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {
        $this->timestamp = time();
        return true;
    }

    public static function log($request, $response, $responseCode, $totalTime, $logLevel)
    {
        if (!$logLevel) {
            $logLevel = Yii::app()->params['apiLogLevel'];
        }
        if ($logLevel == 'all' || $responseCode != 200 && $logLevel == 'error') {
            $apilog = new Apilog();
            $apilog->request = print_r($request, true);
            $apilog->response = print_r($response, true);
            $apilog->response_code = $responseCode;
            $apilog->total_time = $totalTime;
            $apilog->save();
        }
    }

}
