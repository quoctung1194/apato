<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Management\ProviderServiceTypeAction;

class ProviderServiceTypeController extends Controller {
	
	public function getJsonList($serviceTypeId) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		$params = [];
		
		//Lấy danh sách providerServiceType dựa vào $serviceTypeId
		$action = new ProviderServiceTypeAction();
		$conditions = function($query) use ($serviceTypeId) {
			$query->where('service_types.id', '=', $serviceTypeId)
				->orderBy('providers.name', 'asc');
				
		};
		
		$list = $action->getList($conditions);
		
		return response()->json([
			'list' => $list,
		]);
	}
	
	private function checkIsSuperAdmin() {
		$admin = auth()->guard('admin')->user();
	
		if ($admin->is_super_admin == 0) {
			abort(403);
		}
	}
	
}