<?php

class ApiController extends Controller
{

    public function actionMetricsBySites($sites, $from, $to, $interval = 'hour')
    {
        $metrics = $this->getMetricsList();

        $from = strtotime($from);
        $to = strtotime($to);

        $sites = $this->getSurveysOfSite($sites);
        $sitesValues = array();
        foreach ($sites as $site => $surveys) {
            $surveys = $this->getSurveys($surveys);
            $values = $this->getMetrics($surveys, $from, $to, $interval, $metrics, true);
            $sitesValues[$site] = $values;
        }
        $this->outputJSON($sitesValues);
    }

    protected function getSurveysOfSite($site)
    {
        $surveys = array(
            'uutiset-ja-ajankohtaisohjelmat' => 'uutiset',
            'uutiset-ja-alueet' => 'uutiset,urheilu',
            'urheilu' => 'urheilu',
            'areena-ja-ohjelmat' => 'areena,Yle Puhe,Yle Radio 1,Yle Radio Suomi',
            'areena' => 'areena',
            'desktop' => 'areena',
            'oppiminen' => 'oppiminen',
            'elava-arkisto' => 'Elävä arkisto',
        );
        if ($site == 'all') {
            return $surveys;
        } else {
            return $surveys[$site];
        }
    }

    public function actionMetrics($sites, $from, $to, $interval = 'hour')
    {
        $metrics = $this->getMetricsList();

        $from = strtotime($from);
        $to = strtotime($to);
        $surveys = $this->getSurveys($sites);
        $values = $this->getMetrics($surveys, $from, $to, $interval, $metrics, true);
        $this->outputJSON($values);
    }

    public function actionAnswers($sites, $from, $to, $limit = 30, $fromId = null)
    {
        $from = strtotime($from);
        $to = strtotime($to);
        $surveyIds = $this->getSurveyIds($sites);

        $answers = Answer::getAnswers($surveyIds, $from, $to, $limit, true, $fromId);
        $this->outputJSON($answers);
    }

    public function actionTopics($sites, $from, $to, $limit = 10)
    {
        $from = strtotime($from);
        $to = strtotime($to);
        $surveyIds = $this->getSurveyIds($sites);
        $topics = Topic::getTopics($surveyIds, $from, $to, $limit, true);
        $this->outputJSON($topics);
    }

    protected function getSurveys($sites)
    {
        if ($sites == 'all') {
            $surveys = Survey::model()->findAll();
        } else {
            $sites = explode(',', $sites);
            $surveys = Survey::model()->findAllByAttributes(array(
                'category' => $sites,
            ));
        }
        return $surveys;
    }

    protected function getMetrics($surveys, $from, $to, $interval, $metrics, $sitesTogether)
    {
        $surveyIds = array();
        foreach ($surveys as $survey) {
            $surveyIds[] = $survey->id;
        }
        $values = array();
        if (in_array('gender', $metrics)) {
            $values['gender'] = array(
                'female' => $this->valuesToSeries(Answer::getGender($surveyIds, $from, $to, $interval, 'female', $sitesTogether), $from, $to, $interval, false),
                'male' => $this->valuesToSeries(Answer::getGender($surveyIds, $from, $to, $interval, 'male', $sitesTogether), $from, $to, $interval, false),
            );
        }
        if (in_array('age', $metrics)) {
            $values['age'] = array(
                '75+' => $this->valuesToSeries(Answer::getAge($surveyIds, $from, $to, $interval, 75, 200, $sitesTogether), $from, $to, $interval, false),
                '60-74' => $this->valuesToSeries(Answer::getAge($surveyIds, $from, $to, $interval, 60, 74, $sitesTogether), $from, $to, $interval, false),
                '45-59' => $this->valuesToSeries(Answer::getAge($surveyIds, $from, $to, $interval, 45, 59, $sitesTogether), $from, $to, $interval, false),
                '30-44' => $this->valuesToSeries(Answer::getAge($surveyIds, $from, $to, $interval, 30, 44, $sitesTogether), $from, $to, $interval, false),
                '15-29' => $this->valuesToSeries(Answer::getAge($surveyIds, $from, $to, $interval, 15, 29, $sitesTogether), $from, $to, $interval, false),
                '0-14' => $this->valuesToSeries(Answer::getAge($surveyIds, $from, $to, $interval, 0, 14, $sitesTogether), $from, $to, $interval, false),
            );
        }
        if (in_array('success', $metrics)) {
            $values['success'] = $this->valuesToSeries(Answer::getSuccess($surveyIds, $from, $to, $interval, $sitesTogether), $from, $to, $interval);
        }
        if (in_array('interest', $metrics)) {
            $values['interest'] = $this->valuesToSeries(Answer::getInterest($surveyIds, $from, $to, $interval, $sitesTogether), $from, $to, $interval);
        }
        if (in_array('nps', $metrics)) {
            $values['nps'] = $this->valuesToSeries(Answer::getNPS($surveyIds, $from, $to, $interval, $sitesTogether), $from, $to, $interval);
            $values['nps']['average'] = Answer::getTotalNPS($surveyIds, $from, $to, $sitesTogether);
        }
        if (in_array('sentiment', $metrics)) {
            $values['sentiment'] = $this->valuesToSeries(Answer::getSentiment($surveyIds, $from, $to, $interval, $sitesTogether), $from, $to, $interval);
        }
        $values['n'] = Answer::getTotalN($surveyIds, $from, $to, $sitesTogether);
        $values['n'] = $values['n'][0];
        return $values;
    }

    protected function getTickInterval($interval)
    {
        //Hour
        if ($interval == 'hour')
            return 60 * 60;
        //Day
        if ($interval == 'day')
            return 60 * 60 * 24;
        //Week
        if ($interval == 'week')
            return 60 * 60 * 24 * 7;
    }

    protected function valuesToSeries($values, $from, $to, $interval, $calculateAverage = true)
    {
        $valuesArray = array();
        $valuesTotal = 0;
        $valuesCount = 0;
        $start = $from - date('Z');
        $i = 0;
        $tickInterval = $this->getTickInterval($interval);
        while ($start <= $to + 24 * 60 * 60) {
            if (isset($values[$i])) {
                if ($values[$i]['timestamp'] >= $start && $values[$i]['timestamp'] < $start + $tickInterval) {
                    $valuesCell = array('count' => $values[$i]['value']);
                    if (!isset($valuesCell['time'])) {
                        //Summertime starts adjust
                        if (!date('I', $start) && date('I', $start + $tickInterval)) {
                            $start -= 60 * 60;
                        }
                        $valuesCell['time'] = date('c', $start);
                    }

                    $valuesArray[] = $valuesCell;

                    //Add data for calculating average and total
                    $valuesTotal += $values[$i]['value'] * $values[$i]['count'];
                    if ($calculateAverage) {
                        $valuesCount += $values[$i]['count'];
                    }
                    $i++;
                }
            }
            $start += $tickInterval;
        }

        $results = array(
            'history' => $valuesArray
        );

        //Calculate average
        if ($calculateAverage) {
            if ($valuesCount) {
                $valuesAverage = round($valuesTotal / $valuesCount, 2);
            } else {
                $valuesAverage = '';
            }
            $results['average'] = $valuesAverage;
        } else {
            $results['total'] = $valuesTotal;
        }


        return $results;
    }

    /**
     * Convert PHP Array to JSON and print it
     * @param type $array
     */
    protected function outputJSON($array)
    {
        $this->toInteger($array);
        header('Content-Type: application/json');
        $output = json_encode($array);
        if (isset($_GET['callback'])) {
            $output = $_GET['callback'] . '(' . $output . ');';
        }
        echo $output;
    }

    /**
     * Converts numeric variables to integers.
     * @param type $array
     */
    protected function toInteger(&$array)
    {
        foreach ($array as &$value) {
            if (is_array($value))
                $this->toInteger($value);
            if (is_numeric($value)) {
                $value = (double) $value;
            }
        }
    }

    protected function getMetricsList()
    {
        if (Yii::app()->request->getQuery('metrics')) {
            $metrics = array(Yii::app()->request->getQuery('metrics'));
        } else {
            $metrics = array(
                'gender',
                'age',
                'success',
                'interest',
                'nps',
                'sentiment',
            );
        }
        return $metrics;
    }

}