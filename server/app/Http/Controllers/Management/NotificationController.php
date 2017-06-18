<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Actions\Management\NotificationAction;
use App\Actions\Management\SurveyAction;
use App\Actions\Management\App\Actions\Management;

class NotificationController extends Controller {
	
	const PACKAGE = 'managements.notifications';
	
	function show($id = -1) {
		$params = [];
		
		if($id == -1) {
			$notification = new Notification();
		} else {
			$notification = Notification::findOrFail($id);
		}
		
		$params['notification'] = $notification;
		$params['menu'] = 'MN';
		return $this->view('edit', $params);
	}
	
	function edit(Request $request) {
		if(empty($request->id)) { // create new
			$entity = new Notification();
		} else { // retrieve
			$entity = Notification::find($request->id);
		}

		// fill all value into entity
		$entity->fill($request->all());
		if(empty($request->isStickyHome)) {
			$entity->isStickyHome = false;
		}
		if(empty($request->remind)) {
			$entity->remindDate = null;
		}

		// assign current apartmentId
		$admin = auth()->guard('admin')->user();
		$entity->apartment_id = $admin->apartment->id;

		// save into database
		$entity->save();

		// redirect to detail page		
		return redirect()->route('MM-002', ['id' => $entity->id]);
	}
	
	function showList() {
		try {
			$admin = auth()->guard('admin')->user();
			
			$params = [];
			$notifications = Notification::has('createdBy')
				->where([
					['apartment_id', '=', $admin->apartment->id],
					['notificationType', '=', '0']
				])
				->orderBy('created_at', 'desc')
				->get();

			$params['notifications'] = $notifications;
			$params['menu'] = 'MN';
			return $this->view('showList', $params);
		} catch (\Exception $ex) {
			Log::error("App\Http\Controllers\Management\ NotificationController - showList - " . $ex->getMessage());
		}
	}
	
	//Survey Region - START 
	function showSurveyList() {
		try {
			$params = [];
			$admin = auth()->guard('admin')->user();
			$surveys = Notification::where([
					['apartment_id', '=', $admin->apartment->id],
					['notificationType', '=', '1']
			])
			->whereNull('deleted_at')
			->orderBy('created_at', 'desc')
			->get();
			
			$params['menu'] = 'MS';
			$params['surveys'] = $surveys;
			return $this->view('showSurveyList', $params);
		} catch (\Exception $ex) {
			Log::error("App\Http\Controllers\Management\ NotificationController - showSurveyList - " . $ex->getMessage());
		}
	}
	
	function showSurvey($id = -1) {
		$params = [];
		
		if($id == -1) {
			$notification = new Notification();
		} else {
			$notification = Notification::findOrFail($id);
		}
		
		$params['menu'] = 'MS';
		$params['notification'] = $notification;
		return $this->view('editSurvey', $params);
	}
	
	function editSurvey(Request $request) {
		try {
				
			$params = [];
				
			$surveyAction =  new SurveyAction();
			$notification = $surveyAction->save($request->all());
				
			if($notification == null) {
				$notification = new Notification();
			}
				
			$params['notification'] = $notification;
			//return $this->view('edit', $params);
			return redirect()->route('MM-004');
				
		} catch(\Exception $ex) {
			Log::error("App\Http\Controllers\Management\ NotificationController - edit - " . $ex->getMessage());
		}
	}
	
	//Survey Region - END 

	public function remove(Request $request)
	{
		
		$entity = Notification::findOrFail($request->id);
		$entity->delete();
		
		return response()->json([
			'success' => true,
		]);
	}

	private function view($view = null, $data = [], $mergeData = []) {
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
}