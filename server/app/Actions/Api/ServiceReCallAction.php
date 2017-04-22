<?php
namespace App\Actions\Api;

use Illuminate\Support\Facades\DB;
use App\ServiceClick;
use App\ServiceReCall;
use App\Actions\Api\ServiceClickAction;

class ServiceReCallAction {
	
	function recall($params) {
		
		//Kiểm tra xem người dùng này có click chưa (Xử lý bug, khúc xử lý này sẽ confirm để xóa)
// 		$clickCount = ServiceClick::where('service_id', $params['service_id'])
// 								->where('user_id', $params['user_id'])
// 								->count();
		
// 		if($clickCount == 0) {
// 			//Insert một dòng để mồi
// 			$serviceClickAction = new ServiceClickAction();
// 			$serviceClickAction->click($params);
// 		}
		
		$fillable = [
			'service_id' => $params['service_id'],
			'user_id' => $params['user_id'],
		];
		
		$recall = ServiceReCall::firstOrNew($fillable);
		
		//Lấy thông tin tương ứng ra
		
		$recall->note = 'CCCCCC';
		
		return $recall->save();
	}
	
}