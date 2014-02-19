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
        $params[':from'] = $from;
        $params[':to'] = $to + 60 * 60;
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
            return 'YEAR(FROM_UNIXTIME(timestamp)), WEEK(FROM_UNIXTIME(timestamp), 1) ';
        } else {
            throw new CHttpException(400, 'Incorrect Interval');
        }
    }

}

?>
