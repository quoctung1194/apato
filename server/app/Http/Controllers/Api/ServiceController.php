<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Api\ServiceAction;
use App\Actions\Api\App\Actions\Api;

class ServiceController extends Controller {
	const PACKAGE = 'api.services';
	
	public function getTypes() {
		$action = new ServiceAction();
		$types = $action->getTypes();
		
		return response()->json([
			'message' =>  $types
		]);
	}
	
	public function getList($serviceType = -1) {
		$action = new ServiceAction();
		$user = \Auth::guard('api')->user();
		$apartment = $user->room->floor->block->apartment;
		$services = $action->getList($serviceType, $apartment->id);
		
		return response()->json([
			'message' =>  $services
		]);
	}
}