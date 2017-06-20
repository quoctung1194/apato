<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Actions\Management\RequirementAction;

class RequirementController extends Controller {
	
	const PACKAGE = 'managements.requirements';
	const MENU = 'MR';
	
	function showList() {
		try {
			$result = array();
			$admin = auth()->guard('admin')->user();
			
			$requirementAction = new RequirementAction();
			$list = $requirementAction->showList($admin->apartment->id);
			
			$result['requirements'] =  $list;
			
			return $this->view('showList', $result);
		} catch (\Exception $ex) {
			Log::error("App\Http\Controllers\Management\NotificationController - showList - " . $ex->getMessage());
		}
	}
	
	function show($id) {
		try {
			$result = array();
			$requirementAction = new RequirementAction();
			
			$result['requirement'] = $requirementAction->getRequirement($id);
			return $this->view('show', $result);
		} catch (\Exception $ex) {
			Log::error("App\Http\Controllers\Management\NotificationController - show - " . $ex->getMessage());
		}
	}
	
	private function view($view = null, $data = [], $mergeData = []) {
		$data['menu'] = $this::MENU;
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
}