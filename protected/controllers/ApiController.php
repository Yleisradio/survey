<?php

class ApiController extends Controller
{

    public function actionMetrics($sites, $from, $to, $interval = 'hour')
    {
        $metrics = array(
            'gender',
            'age',
            'success',
            'interest',
            'nps',
            'sentiment',
        );

        $from = strtotime($from);
        $to = strtotime($to);

        $sites = explode(',', $sites);
        $sitesValues = array();
        foreach ($sites as $site) {
            $survey = Survey::model()->findByAttributes(array('category' => $site));
            $values = array();
//            if (in_array('gender', $metrics)) {
//                $values['female'] = valuesToSeries(getGender($sitesParameter, $from, $to, 0), $from, $to);
//                $values['male'] = valuesToSeries(getGender($sitesParameter, $from, $to, 1), $from, $to);
//            };
//            if (in_array('age', $metrics)) {
//                $values['75+'] = valuesToSeries(getAge($sitesParameter, $from, $to, 75, 200), $from, $to);
//                $values['60-74'] = valuesToSeries(getAge($sitesParameter, $from, $to, 60, 74), $from, $to);
//                $values['45-59'] = valuesToSeries(getAge($sitesParameter, $from, $to, 45, 59), $from, $to);
//                $values['30-44'] = valuesToSeries(getAge($sitesParameter, $from, $to, 30, 44), $from, $to);
//                $values['15-29'] = valuesToSeries(getAge($sitesParameter, $from, $to, 15, 29), $from, $to);
//                $values['0-14'] = valuesToSeries(getAge($sitesParameter, $from, $to, 0, 14), $from, $to);
//            };
            if (in_array('success', $metrics)) {
                $values['success'] = $this->valuesToSeries(Answer::getSuccess($survey->id, $from, $to, $interval), $from, $to, $interval);
            }
            if (in_array('interest', $metrics)) {
                $values['interest'] = $this->valuesToSeries(Answer::getInterest($survey->id, $from, $to, $interval), $from, $to, $interval);
            }
            if (in_array('nps', $metrics)) {
                $values['nps'] = $this->valuesToSeries(Answer::getNPS($survey->id, $from, $to, $interval), $from, $to, $interval);
                $values['nps']['average'] = Answer::getTotalNPS($survey->id, $from, $to);
            }
            if (in_array('sentiment', $metrics)) {
                $values['sentiment'] = $this->valuesToSeries(Answer::getSentiment($survey->id, $from, $to, $interval), $from, $to, $interval);
            }
            $values['n'] = Answer::getTotalN($survey->id, $from, $to);
            $sitesValues[$site] = $values;
        }
        $this->outputJSON($sitesValues);
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

    protected function valuesToSeries($values, $from, $to, $interval)
    {
        $valuesArray = array();
        $valuesTotal = 0;
        $valuesCount = 0;
        $start = $from;
        $i = 0;
        $tickInterval = $this->getTickInterval($interval);

        while ($start <= $to + 24 * 60 * 60) {
            if (isset($values[$i])) {
                if ($values[$i]['timestamp'] >= $start && $values[$i]['timestamp'] < $start + $tickInterval) {
                    $valuesCell = array('value' => $values[$i]['value']);
//                    $valuesCell['timestamp'] = $start + (2 * 60 * 60);
                    $valuesCell['time'] = date('c', $start);
//                    if (date('I', $start)) {
//                        $valuesCell['timestamp'] += 60 * 60;
//                    }
                    $valuesArray[] = $valuesCell;

                    //Calculate average
                    $valuesTotal += $values[$i]['value'] * $values[$i]['count'];
                    $valuesCount += $values[$i]['count'];
                    $i++;
                }
            }
            $start += $tickInterval;
        }


        if ($valuesCount) {
            $valuesAverage = round($valuesTotal / $valuesCount, 2);
        } else {
            $valuesAverage = '';
        }

        return array('average' => $valuesAverage, 'history' => $valuesArray);
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

}