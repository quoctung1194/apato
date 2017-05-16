<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;

class ServiceClickAction {
	
	public function getClickListByService($params) {
		
		//Khai báo mới dữ trả về
		$params['data'] = array();
		//Mảng của các thuộc tính(column) để hiển thị trên giao diện
		$columns = array(
				'none',
				'first_name',
				'last_name',
				'apartment_name',
				'block_name',
				'floor_name',
				'room_name',
				'clicks',
				'none',
		);
		//Lấy ra vị trí được sort
		$sortedIndex = $params['order']['column'];
		
		$query = DB::table('users')
					->select('users.id as userId',
							'users.first_name',
							'users.last_name',
							'apartments.name as apartment_name',
							'blocks.name as block_name',
							'floors.name as floor_name',
							'rooms.name as room_name',
// 							'service_re_calls.note as note',
							DB::raw('COUNT(service_clicks.id) as clicks'))
					->join('service_clicks', 'service_clicks.user_id', '=' ,'users.id')
					->join('services', 'service_clicks.service_id', '=', 'services.id')
					->join('rooms', 'rooms.id', '=', 'users.room_id')
					->join('floors', 'floors.id', '=', 'rooms.floor_id')
					->join('blocks', 'blocks.id', '=', 'floors.block_id')
					->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')
					//->leftJoin('service_re_calls', 'service_re_calls.user_id', '=', 'users.id')

					->whereNull('users.deleted_at')
					->whereNull('services.deleted_at')
					->whereNull('rooms.deleted_at')
					->whereNull('floors.deleted_at')
					->whereNull('blocks.deleted_at')
					->whereNull('apartments.deleted_at')
					->where('services.id', '=' , $params['serviceId'])
					->groupBy('users.id');
		
		//Tổng số record PHÙ HỢP trong database
		$params['recordsTotal'] = $query->count();
		//Tổng số record ĐƯỢC LỌC VÀ PHÙ HỢP trong database
		$params['recordsFiltered'] = $query->count();
		
		//Danh sách item hiển thị trên màn hình tại vị trí trang tương ứng
		$params['data'] = $query->skip($params['start'])
		->take($params['length'])
		->orderBy(
			$columns[$sortedIndex],
			$params['order']['dir']
		)
		->get();
		
		//Tạo số thứ tự, đối với phân trang ở client thì có common làm sẵn
		//ko cần làm bước này ở server
		$count = $params['start'];
		foreach($params['data'] as $item) {
			$item->stt = ++$count;
		}
		
		return $params;
					
		return $query->get();
	}
	
	/**
	 * Tính tổng số click dựa trên service Id, tính luôn user đã bị delete
	 * @param $serviceId: id của dịch vụ
	 */
	public function getTotalClickByService($serviceId) {
		
		$query = DB::table('service_clicks')
				->where('service_clicks.service_id', '=' , $serviceId);
		
		return $query->count();
	}
	
}
