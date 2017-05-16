<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Api\ServiceCallAction;

class ServiceCallController extends Controller {
		
	public function getPermission($serviceId) {
		
		//Khởi tạo action
		$action = new ServiceCallAction();
		
		//Khởi tao param
		$params['service_id'] = $serviceId;
		$user = \Auth::guard('api')->user();
		$params['user_id'] = $user->id;
		$permission = $action->getPermission($params);
		
		return response()->json($permission);
	}
}