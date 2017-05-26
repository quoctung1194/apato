<?php
namespace App\Http\Controllers\Api;

use App\Actions\Api\SettingAction;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller {
	const PACKAGE = 'api.settings';
	
	public function getSettings($id) {
		try {
			$settingAction = new SettingAction();
			$result = $settingAction->getSettings($id);
				
			return response()->json([
					'message' => $result
			]);
		} catch (\Exception $ex) {
			Log::error("SettingController - getSettings - " . $ex->getMessage());
			return response()->json([
					'errors' => [ $ex->getMessage()]
			]);
		}
	}
}