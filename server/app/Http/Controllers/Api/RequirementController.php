<?php
namespace App\Http\Controllers\Api;

use App\Actions\Api\SettingAction;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Actions\Api\RequirementAction;
use Illuminate\Support\Facades\Input;

class RequirementController extends Controller {
	
	public function save(Request $request) {
		try {
			$requirementAction = new RequirementAction();
			$params = $request->all();
			$user = \Auth::guard('api')->user();
			
			$isSaved = $requirementAction->save($params, $user->id);
			if(!$isSaved) {
				throw new \Exception;
			}
			return response()->json([
				'message' => $isSaved
			]);
		} catch (\Exception $ex) {
			Log::error("RequirementController - save - " . $ex->getMessage());
			return response()->json([
				'errors' => [ $ex->getMessage()]
			]);
		}
	}
}