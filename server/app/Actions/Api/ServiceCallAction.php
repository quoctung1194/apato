<?php
namespace App\Actions\Api;

use Illuminate\Support\Facades\DB;
use App\ServiceCall;
use Carbon\Carbon;

class ServiceCallAction {
	
	function getPermission($params) {
		
		//Kiểm tra xem đủ số cuộc gọi trong ngày chưa
		$callCount = ServiceCall::where('service_id', $params['service_id'])
								->where('user_id', $params['user_id'])
								->whereDate('created_at', Carbon::today()->toDateString())
								->count();
		
		$result = array();
		
		if($callCount < 3) {
			//Insert một dòng mới
			$serviceCall = new ServiceCall();
			$serviceCall->service_id = $params['service_id'];
			$serviceCall->user_id = $params['user_id'];
			
			$result['result'] = $serviceCall->save();
		} else {
			$result['result'] = false;
			$result['message'] = 'Chỉ được gọi tối đa 3 cuộc gọi trên ngày.';
		}
	
		return $result;
	}
	
}