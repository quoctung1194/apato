<?php
namespace App\Actions\Api;

use App\Setting;
class SettingAction {
	
	function getSettings($id) {
		$setting = Setting::where('apartment_id', '=', $id)->first();
		$result = array();
		
		$result['types'] = $setting->getTypes();
		$result['tags'] = $setting->getTags();
		
		return $result;
	}
	
}