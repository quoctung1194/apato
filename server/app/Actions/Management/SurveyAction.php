<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\Log;

use App\Notification;
use App\SurveyOption;
use Illuminate\Support\Facades\DB;
use App\UserSurvey;

class SurveyAction {

    public function save($params) {
        try
        {
            $admin = auth()->guard('admin')->user();
            if(empty($params['id']))
            {
                $id = null;
            }
            else
            {
                $id = $params['id'];
            }
    
            $notification = Notification::firstOrNew
            ([
                    'id' => $id,
            ]);
    
            $notification->title = $params['title'];
            $notification->subTitle = $params['subTitle'];
            $notification->content = $params['content'];
            $notification->notificationType = Notification::TYPE_SURVEY;
            
            $notification->apartment_id = $admin->apartment->id;
            $notification->created_by = $admin->id;
            //END
            
            if(!empty($params['typeCheck'])) {
                $notification->type_check = $params['typeCheck'];
            }

            if(!empty($params['sticky'])) {
                $notification->isStickyHome = 1;
            }
                
            if(!empty($params['remindCalender'])) {
                $notification->remindDate = $params['remindCalender'];
            }
            $notification->save();
            
            DB::beginTransaction();
            //Create Option
            $options = json_decode($params['options']);
            
            foreach($options as $option) {
                if($option->isOther) {
                    $temp = $option;
                    continue;
                }
                $surOption = new SurveyOption();
                $surOption->notification_id = $notification->id;
                $surOption->content = $option->content;
                $surOption->is_other = $option->isOther;
                
                $surOption->color = $this->rand_color();
                $surOption->save();
            }
            
            if(isset($temp)) {
                $surOption = new SurveyOption();
                $surOption->notification_id = $notification->id;
                $surOption->content = $temp->content;
                $surOption->is_other = $temp->isOther;
                
                $surOption->color = $this->rand_color();
                $surOption->save();
            }
            
            DB::commit();
            
            $this->sendMessage($notification);
            if(!empty($notification->remindDate)) {
                $this->sendMessage($notification, $notification->remindDate);
            }
            
            return $notification;
        }
        catch(\Exception $ex)
        {
            Log::error("NotificationAction - save - " . $ex->getMessage());
            DB::rollBack();
            return null;
        }
    }
    
    private function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
    private function sendMessage($notification, $remindDate=""){
        $content = array(
                "en" => $notification->subTitle
        );
        $heading = array(
                "en" => $notification->title
        );
        
    
        $fields = array(
                'app_id' => "a475acbd-6d3a-4113-a9b7-152dce36478f",
                'data' => array("notificationId" => $notification->id, 'isSurvey' => true),
                'contents' => $content,
                'headings' => $heading,
                'priority' => 10,
                'filters' => array(
                    array(
                        "field" => "tag",
                        "key" => "apartmentId",
                        "relation" => "=",
                        "value" => $notification->apartment_id
                    )
                ),
        );
        
        if(!empty($remindDate)) {
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
    
    function getChartResult($notificationId) {
        $notification = Notification::findOrFail($notificationId);
        $surveyOptions = $notification->surveyOptions;
        $userOptions = array();
        
        foreach($surveyOptions as $option) {
            $userOption = new \stdClass();
            $userOption->id = $option->id;
            $userOption->content = $option->content;
            $userOption->isOther = $option->is_other;
            
            
            //GET data for chart
            $count = UserSurvey::where([
                    ['survey_options_id', '=', $option->id]
            ])->count();
            $userOption->chartNumber = $count;
            $userOption->color = $option->color;
            $userOptions[] =  $userOption;
        }
                
        return $userOptions;
    }
}
