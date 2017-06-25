<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Actions\Management\NotificationAction;
use App\Actions\Management\SurveyAction;
use App\Actions\Management\App\Actions\Management;
use App\Helpers\OnesignalApi;
use App\SurveyOption;
use App\User;
use App\UserNotification;

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

		// display list block of current manager
		$admin = auth()->guard('admin')->user();
		$blocks = $admin->apartment->blocks;
		$params['blocks'] = [];
		// convert into key-value array for render combobox
		$params['blocks'][''] = '';
		foreach ($blocks as $item) {
			$params['blocks'][$item->id] = $item->name;
		}

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
		// assign blockId
		if(!empty($request->block_id)) {
			$entity->block_id = $request->block_id;
		} else {
			$entity->block_id = null;
		}

		// save into database
		$entity->save();

		//save private notifications
		$entity->receivers()->delete();

		$receivers = [];
		$userIds = explode(',', $request->privateUserList);
		foreach($userIds as $id) {
			if($id == "") {
				continue;
			}

			$userNotification = new UserNotification();
			$userNotification->user_id = $id;

			$receivers[] = $userNotification;
		}

		$entity->receivers()->saveMany($receivers);

		// send notifications
		$params = [
			'title' => $entity->title,
			'subTitle' => $entity->subTitle,
			'remindDate' => $entity->remindDate,
			'id' => $entity->id
		];

		// process send block or apartment
		if(!empty($entity->block_id)) { // sending block
			$filters = [
				[
					"field" => "tag",
					"key" => "blockId",
					"relation" => "=",
					"value" => $entity->block_id
				]
			];
		} else { // sending apartment
			$filters = [
				[
					"field" => "tag",
					"key" => "apartmentId",
					"relation" => "=",
					"value" => $entity->apartment_id
				]
			];
		}

		OnesignalApi::send($params, $filters);

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
			$surveys = Notification::has('createdBy')
				->where([
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
	
	function showSurvey($id = -1)
	{
		$params = [];
		
		if($id == -1) {
			$notification = new Notification();
		} else {
			$notification = Notification::findOrFail($id);
		}
		
		$params['notification'] = $notification;
		$params['menu'] = 'MS';

		// display list block of current manager
		$admin = auth()->guard('admin')->user();
		$blocks = $admin->apartment->blocks;
		$params['blocks'] = [];
		// convert into key-value array for render combobox
		$params['blocks'][''] = '';
		foreach ($blocks as $item) {
			$params['blocks'][$item->id] = $item->name;
		}

		return $this->view('editSurvey', $params);
	}
	
	function editSurvey(Request $request)
	{
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
		$entity->notificationType = Notification::TYPE_SURVEY;
		// assign blockId
		if(!empty($request->block_id)) {
			$entity->block_id = $request->block_id;
		} else {
			$entity->block_id = null;
		}

		// checking is create or update
		$isCreate = true;
		if(!empty($entity->id)) {
			$isCreate = false;
		}

		// save into database
		$entity->save();

		//save private notifications
		$entity->receivers()->delete();

		$receivers = [];
		$userIds = explode(',', $request->privateUserList);
		foreach($userIds as $id) {
			if($id == "") {
				continue;
			}

			$userNotification = new UserNotification();
			$userNotification->user_id = $id;

			$receivers[] = $userNotification;
		}

		$entity->receivers()->saveMany($receivers);
		
		if($isCreate) {
			//Create Option
			$options = json_decode($request->options);
			$entity->surveyOptions()->delete();

			foreach($options as $option) {
				$surOption = new SurveyOption();
				$surOption->notification_id = $entity->id;
				$surOption->content = $option->content;
				$surOption->is_other = $option->isOther;
				
				$surOption->color = $this->rand_color();
				$surOption->save();
			}
		}

		// send notifications
		$params = [
			'title' => $entity->title,
			'subTitle' => $entity->subTitle,
			'remindDate' => $entity->remindDate,
			'id' => $entity->id
		];

		// process send block or apartment
		if(!empty($entity->block_id)) { // sending block
			$filters = [
				[
					"field" => "tag",
					"key" => "blockId",
					"relation" => "=",
					"value" => $entity->block_id
				]
			];
		} else { // sending apartment
			$filters = [
				[
					"field" => "tag",
					"key" => "apartmentId",
					"relation" => "=",
					"value" => $entity->apartment_id
				]
			];
		}

		OnesignalApi::send($params, $filters);

		// redirect to detail page		
		return redirect()->route('MM-004', ['id' => $entity->id]);
	}

	/**
	 * Show user list
	 */
	public function showUsers()
	{
		//init view params
		$params = [];

		// get users list of department admin
		$users = User::whereHas('room.floor.block.apartment', function($query) {
			// get admin
			$admin = auth()->guard('admin')->user();
			$query->where('apartments.id', $admin->apartment->id);
		})
		->whereNull('deleted_at')
		->orderBy('username', 'asc')
		->paginate(8);

		$params['users'] = $users;
			
		// redirect to detail page		
		return $this->view('showUsers', $params);
	}
	
	private function rand_color()
	{
		return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
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