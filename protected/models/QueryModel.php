<?php

class QueryModel extends CActiveRecord
{

    /**
     * Returns the condition used to get the survey result metrics
     * @param type $surveyId
     * @return string
     */
    protected static function getWhereCondition($surveyIds, $sitesTogether)
    {
        $whereCondition = ' answer.timestamp >= :from AND answer.timestamp <= :to';
        if ($sitesTogether) {
            if ($surveyIds) {
                $whereCondition .= ' AND survey_id IN (' . implode(', ', $surveyIds) . ')';
            } else {
                $whereCondition .= ' AND 1 = 2';
            }
        } else {
            if ($surveyIds) {
                $whereCondition .= ' AND survey_id = ' . $surveyIds;
            } else {
                $whereCondition .= ' AND 1 = 2';
            }
        }
        if (Yii::app()->request->getQuery('gender')) {
            $whereCondition .= ' AND gender = :gender_filter';
        }
        if (Yii::app()->request->getQuery('age')) {
            $whereCondition .= ' AND year_of_birth <= :startAge_filter AND year_of_birth > :endAge_filter';
        }
        if (Yii::app()->request->getQuery('recommend-min')) {
            $whereCondition .= ' AND recommend >= :recommend_min AND recommend IS NOT null';
        }
        if (Yii::app()->request->getQuery('recommend-max')) {
            $whereCondition .= ' AND recommend <= :recommend_max AND recommend IS NOT null';
        }
        if (Yii::app()->request->getQuery('interest-min')) {
            $whereCondition .= ' AND interest >= :interest_min';
        }
        if (Yii::app()->request->getQuery('interest-max')) {
            $whereCondition .= ' AND interest <= :interest_max';
        }
        if (Yii::app()->request->getQuery('text-only')) {
            $whereCondition .= ' AND (failure_text > "" OR feedback > "")';
        }
        if (Yii::app()->request->getQuery('failed-only')) {
            $whereCondition .= ' AND success = 0';
        }
        if (Yii::app()->request->getQuery('sentiment')) {
            $sentiment = Yii::app()->request->getQuery('sentiment');
            if ($sentiment == 'negative') {
                $whereCondition .= ' AND sentiment < 0';
            } else if ($sentiment == 'neutral') {
                $whereCondition .= ' AND sentiment == 0';
            } else if ($sentiment == 'positive') {
                $whereCondition .= ' AND sentiment > 0';
            }
        }
        return $whereCondition;
    }

    /**
     * Returns the where params used to get the survey result metrics
     * @param type $surveyId
     * @param type $from
     * @param type $to
     * @return type
     */
    protected static function getWhereParams($surveyIds, $from, $to, $sitesTogether)
    {
        $params = array();
        $params[':from'] = $from - date('Z', $from);
        $params[':to'] = $to - date('Z', $from);
        if (Yii::app()->request->getQuery('gender')) {
            $params[':gender_filter'] = Yii::app()->request->getQuery('gender');
        }
        if (Yii::app()->request->getQuery('age')) {
            $year = date('Y');
            if (strstr(Yii::app()->request->getQuery('age'), '-')) {
                $ageLimits = explode('-', Yii::app()->request->getQuery('age'));
                $startAge = $ageLimits[0];
                $endAge = $ageLimits[1];
            } else {
                $startAge = 75;
                $endAge = 200;
            }
            $params[':startAge_filter'] = $year - $startAge;
            $params[':endAge_filter'] = $year - $endAge;
        }
        if (Yii::app()->request->getQuery('recommend-min')) {
            $params['recommend_min'] = Yii::app()->request->getQuery('recommend-min');
        }
        if (Yii::app()->request->getQuery('recommend-max')) {
            $params['recommend_max'] = Yii::app()->request->getQuery('recommend-max');
        }
        if (Yii::app()->request->getQuery('interest-min')) {
            $params['interest_min'] = Yii::app()->request->getQuery('interest-min');
        }
        if (Yii::app()->request->getQuery('interest-max')) {
            $params['interest_max'] = Yii::app()->request->getQuery('interest-max');
        }
        return $params;
    }

    /**
     * Returns the group by statement used to get the survey result metrics
     * @param type $interval
     * @return string
     */
    protected static function getGroupBy($interval)
    {
        if ($interval == 'hour') {
            return 'YEAR(FROM_UNIXTIME(timestamp)), DAYOFYEAR(FROM_UNIXTIME(timestamp)), HOUR(FROM_UNIXTIME(timestamp)) ';
        } else if ($interval == 'day') {
            return 'YEAR(FROM_UNIXTIME(timestamp)), DAYOFYEAR(FROM_UNIXTIME(timestamp)) ';
        } else if ($interval == 'week') {
            return 'YEARWEEK(FROM_UNIXTIME(timestamp), 1)';
        } else {
            throw new CHttpException(400, 'Incorrect Interval');
        }
    }

}

?>
