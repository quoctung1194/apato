<?php
namespace App\Actions\Api;

use App\User;
use App\SurveyOption;
use App\Notification;
use App\UserSurvey;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyAction {
	
	function isCompletedByUser($userId, $notificationId) {
		try {

			$notificationId = Notification::findOrFail($notificationId);
			$surveyOptions = $notificationId->surveyOptions;
			
			foreach($surveyOptions as $option) {
				$count = UserSurvey::where([
							['user_id', '=', $userId],
							['survey_options_id', '=', $option->id]
						 ])->count();
				
				if($count > 0) {
					return true;
				}
			}
			
			return false;
		} catch(\Exception $ex) {
			Log::error("App\Use\SurveyAction - isCompletedByUser - " . $ex->getMessage());
			return false;
		}
	}
	
	function getOptions($notificationId) {
		try {
		
			$notificationId = Notification::findOrFail($notificationId);
			$surveyOptions = $notificationId->surveyOptions;
				
			return $surveyOptions;
		} catch(\Exception $ex) {
			Log::error("App\Use\SurveyAction - getOption - " . $ex->getMessage());
			array();
		}
	}
	
	function saveResults($data, $userId) {
		try {
			$options = $data->result;
			$notificationId = $data->notificationId;
			
			DB::beginTransaction();
			//Delete all UserSurveys
			if(!$this->deleteUserSurveysNotificationId($notificationId, $userId)) {
				DB::rollBack();
				return false;
			}
			
			//Insert userServeys
			foreach($options as $option) {
				$userSurvey = new UserSurvey;
				$userSurvey->user_id = $userId;
				
				$userSurvey->survey_options_id = $option->id;
				if(isset($option->otherContent)) {
					$userSurvey->other_content = $option->otherContent;
				}
				
				$userSurvey->save();
			}
			DB::commit();
			
			return true;
		} catch (\Excetion $ex) {
			Log::error("App\Use\SurveyAction - saveResults - " . $ex->getMessage());
			DB::rollBack();
			return false;
		}
	}
	
	function deleteUserSurveysNotificationId($notificationId, $userId) {
		try {
			$notification = Notification::findOrFail($notificationId);
			$surveyOptions = $notification->surveyOptions;
			foreach($surveyOptions as $option) {
				$userSurveys = UserSurvey::where([
						['user_id', '=', $userId],
						['survey_options_id', '=', $option->id]
				])->get();
				
				foreach($userSurveys as $userSurvey) {
					$userSurvey->delete();
				}
			}

			return true;
		} catch (\Exception $ex) {
			Log::error("App\Use\SurveyAction - deleteUserSurveysNotificationId - " . $ex->getMessage());
			return false;
		}
	}
	
	function getCompletedSurveyData($notificationId, $userId) {
		$notificationId = Notification::findOrFail($notificationId);
		$surveyOptions = $notificationId->surveyOptions;
		$userOptions = array();
		$chartData = array();
		$result = array();
		
		foreach($surveyOptions as $option) {
			$userOption = new \stdClass();
			$userOption->id = $option->id;
			$userOption->content = $option->content;
			$userOption->isOther = $option->is_other;
			
			//Get data for display selection of user
			$userSurveys = UserSurvey::where([
						['user_id', '=', $userId],
						['survey_options_id', '=', $option->id]
					 ])->get();
			
			if(count($userSurveys) > 0) {
				$userOption->checked = true;
				$userOption->otherContent = $userSurveys->first()->other_content;
			} else {
				$userOption->checked = false;
			}
			
			//GET data for chart
			$count = UserSurvey::where([
						['survey_options_id', '=', $option->id]
					 ])->count();
			$userOption->chartNumber = $count;
			$userOption->color = $option->color;
			$userOptions[] =  $userOption;
		}
		
		$result['userOptions'] = $userOptions;
		
		return $result;
	} 
}