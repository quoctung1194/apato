<?php
namespace App\Helpers;

class OnesignalApi
{  
    public static function send($params = [], $filters = [])
    {
        $content = array(
                "en" => $params['subTitle']
        );
        $heading = array(
                "en" => $params['title']
        );
        $remindDate = $params['remindDate'];

        $isSurvey = false;
        if(isset($params['isSurvey'])) {
            $isSurvey = $params['isSurvey'];
        }
    
        $fields = array(
                'app_id' => "a475acbd-6d3a-4113-a9b7-152dce36478f",
                'data' => array("notificationId" => $params['id'], 'isSurvey' => $isSurvey),
                'contents' => $content,
                'headings' => $heading,
                'priority' => 10,
                'filters' => $filters
        );
        
        if(!isset($remindDate)) {
            $fields['send_after'] = $remindDate . " GMT+0700";
        } 
    
        $fields = json_encode($fields);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, 
                array('Content-Type: application/json; charset=utf-8',
                        'Authorization: Basic YTU1ZjAxMTYtYWM2YS00ZWEzLWE1OGMtOGIxNzczYzc1Mjkx')
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
            
        return $response;
    }    
}