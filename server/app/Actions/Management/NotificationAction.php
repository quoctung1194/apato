<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\Log;

use App\Notification;

class NotificationAction {
	
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
			$notification->apartment_id = $admin->apartment->id;
			//END
			
			if(!empty($params['sticky'])) {
				$notification->isStickyHome = 1;
			}
			
			if(!empty($params['remindCalender'])) {
 				$notification->remindDate = $params['remindCalender'];
			}
			$notification->save();
			
			$this->sendMessage($notification);
			if(!empty($notification->remindDate)) {
				$this->sendMessage($notification, $notification->remindDate);
			}
			
			return $notification;
		}
		catch(\Exception $ex)
		{	
			Log::error("NotificationAction - save - " . $ex->getMessage());
			return null;
		}
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
				'data' => array("notificationId" => $notification->id),
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
	
}
