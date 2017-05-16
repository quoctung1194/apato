<?php
namespace App\Actions\Api;

use Illuminate\Support\Facades\DB;
use App\ServiceClick;
use Carbon\Carbon;

class ServiceClickAction {
	
	public function click($params) {
		//Đếm số click hiện hành của ngày hôm nay
		$numberOfToday = ServiceClick::where('service_id', $params['service_id'])
									->where('user_id', $params['user_id'])
									->whereDate('created_at', Carbon::today()->toDateString())
									->count();
		
		if($numberOfToday >= 3) {
			return true;
		}
		
		//tạo mới click
		$serviceClick = new ServiceClick();
		$serviceClick->service_id = $params['service_id'];
		$serviceClick->user_id = $params['user_id'];
		
		return $serviceClick->save();
	}
	
}
