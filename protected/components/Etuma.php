<?php

class Etuma
{

    protected static $endpoint = 'https://www.etuma.eu/websrv/cococo/Rest/';
    
    /**
     * Get request which expects json as response.
     * @param type $url
     * @param type $data
     * @return type
     */
    public static function get($method, $data = null, $options = array())
    {
        $data = self::getData($method, $data);
        $url = self::$endpoint . $method;

        $response = Curl::get($url, $data, $options);
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * Post request which sends json encoded data and expects json as response.
     * @param type $url
     * @param type $data
     * @return type
     */
    public static function post($method, $data, $options = array())
    {
        $data = self::getData($method, $data);
        $url =  self::$endpoint . $method;
        $data = json_encode($data);
        $response = Curl::post($url, $data, $options);
        $response = json_decode($response, true);
        return $response;
    }

    protected static function getSignature($method, $timestamp)
    {
        return hash_hmac('sha1', 'Semport' . $method . $timestamp, Yii::app()->params['etuma']['secretKey']);
    }

    protected static function getData($method, $data)
    {
        if (!$data) {
            $data = array();
        }
        $timestamp = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
        $data = array_merge($data, array(
            'timestamp' => $timestamp,
            'useraccesskey' => Yii::app()->params['etuma']['accessKey'],
            'signature' => self::getSignature($method, $timestamp),
                )
        );
        return $data;
    }

}