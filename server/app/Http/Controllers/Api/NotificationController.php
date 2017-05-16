<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Actions\Api\NotificationAction;
use App\Actions\Api\App\Actions\Api;
use App\Actions\Api\SurveyAction;
use App\Notification;

class NotificationController extends Controller {
	
	const PACKAGE = 'api.notifications';
	
	public function getStickyHomeNotification(Request $request) {
		try {
			$user = \Auth::guard('api')->user();
			$apartment = $user->room->floor->block->apartment;
			$notificationAction = new NotificationAction();
			$result = $notificationAction->getStickyHome($apartment);
			
			return response()->json([
				'message' => $result
			]);
		} catch (\Exception $ex) {
			Log::error("NotificationController - getStickyHomeNotification - " . $ex->getMessage());
			return response()->json([
				'errors' => [ $ex->getMessage()]
			]);
		}
	}
	
	public function getNotificationDetail($id) {
		try {
			$notiticationAction = new NotificationAction();
			$result = $notiticationAction->getNotificationDetail($id);
			
			return response()->json([
				'message' => $result
			]);
		} catch (\Exception $ex) {
			Log::error("NotificationController - getNotificationDetail - " . $ex->getMessage());
			return response()->json([
				'errors' => [ $ex->getMessage()]
			]);
		}
	}
	
	public function displayContentDetail($id) {
		try {
			$result = [];
			
			$notiticationAction = new NotificationAction();
			$notification = $notiticationAction->getNotificationDetail($id);
			$result['notification'] = $notification;
			
			return $this->view('notificationDetail', $result);
		} catch (\Exception $ex) {
			Log::error("NotificationController - displayContentDetail - " . $ex->getMessage());
			return response()->json([
				'errors' => [ $ex->getMessage()]
			]);
		}
	}
	
	public function getSurveyData($notificationId) {
		try {
			$result = [];
			
			$notificationAction = new NotificationAction();
			$notification = $notificationAction->getNotificationDetail($notificationId);
			$result['survey'] = $notification;
			
			//Get HTML Content
			$title = mb_strtoupper($notification->title, 'UTF-8');
			$createdDate = $notification->created_at;
			$subTitle = $notification->subTitle;
			$content = $notification->content;
					
// 			$htmlContent = '
// 			<html>
// 				<head></head>
// 				<body>
// 						' .$content. '
// 				</body>
// 			</html>
// 			';
			
// 			$result['htmlContent'] = $htmlContent;
			
			//Get options
			$surveyAction = new SurveyAction();
			$options = $surveyAction->getOptions($notificationId);
			$result['options'] = $options;
			
			//Identify Survey is done
			$user = \Auth::guard('api')->user();
			$result['isCompleted'] = $surveyAction->isCompletedByUser($user->id, $notificationId);
			
			return response()->json([
				'message' => $result
			]);
		} catch(\Exception $ex) {
			Log::error("NotificationController - getOptionsByNotification - " . $ex->getMessage());
			return response()->json([
					'errors' => [ $ex->getMessage()]
			]);
		}
	}
	
	public function saveResultsSurvey(Request $request) {
		try {
			$surveyAction = new SurveyAction();
			$data = json_decode($request->getContent());
			$user = \Auth::guard('api')->user();
			
			$isSaved = $surveyAction->saveResults($data, $user->id);
			return response()->json([
					'message' => $isSaved
			]);
		} catch (\Exception $ex) {
			Log::error("NotificationController - saveResultsSurvey - " . $ex->getMessage());
			return response()->json([
					'errors' => [ $ex->getMessage()]
			]);
		}
	}
	
	public function getCompletedSurveyData($notificationId) {
		try {
			$surveyAction = new SurveyAction();
			$user = \Auth::guard('api')->user();
			
			$result = $surveyAction->getCompletedSurveyData($notificationId, $user->id);
			return response()->json([
				'message' => $result
			]);
		} catch (\Exception $ex) {
			Log::error("NotificationController - getCompletedSurveyData - " . $ex->getMessage());
			return response()->json([
					'errors' => [ $ex->getMessage()]
			]);
		}
	}
	
	public function displaySurveyContent($surveyId) {
		try {
			$result = [];
			
			$notiticationAction = new NotificationAction();
			$notification = $notiticationAction->getNotificationDetail($surveyId);
			$result['notification'] = $notification;
			
			return $this->view('surveyDetail', $result);
		} catch (\Exception $ex) {
			Log::error("NotificationController - displaySurveyContent - " . $ex->getMessage());
		}
	}
	
	private function view($view = null, $data = [], $mergeData = []) {
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
	
}
