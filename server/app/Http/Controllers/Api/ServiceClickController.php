<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Api\ServiceClickAction;

class ServiceClickController extends Controller {
		
	public function click($serviceId) {
		
		//Khởi tạo action
		$serviceClickAction = new ServiceClickAction();
		
		//Khởi tao param
		$params = array();
		$params['service_id'] = $serviceId;
		$user = \Auth::guard('api')->user();
		$params['user_id'] = $user->id;
		$click = $serviceClickAction->click($params);
		
		return response()->json([
			'result' =>  $click
		]);
	}
}