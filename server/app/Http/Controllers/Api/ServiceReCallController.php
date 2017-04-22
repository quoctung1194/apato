<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Api\ServiceReCallAction;

class ServiceReCallController extends Controller {
		
	public function recall(Request $request) {
		
		//Khởi tạo action
		$serviceReCallAction = new ServiceReCallAction();
		
		//Khởi tao param
		$params = $request->all();
		$user = \Auth::guard('api')->user();
		$params['user_id'] = $user->id;
		$recall = $serviceReCallAction->recall($params);
		
		return response()->json([
			'result' =>  $recall
		]);
	}
}