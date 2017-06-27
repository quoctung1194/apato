<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;
use App\ServiceType;

class ServiceTypeAction {
	
	public function getList($conditions = null) {
	
		$query = DB::table('service_types')
					->whereNull('deleted_at');
		
		if($conditions != null) {
			$query->where($conditions);
		}
		
		return $query->orderBy('name', 'asc')->get();
	}
	
	public function getJsonList($params) {
		//Khai báo mới dữ trả về
		$params['data'] = array();
		//Mảng của các thuộc tính(column) để hiển thị trên giao diện
		$columns = array(
				'id',
				'name',
				'sortOrder',
				'created_at'
		);
		//Lấy ra vị trí được sort
		$sortedIndex = $params['order']['column'];
		
		//Tạo query truy vấn
		$query = DB::table('service_types')
					->select('service_types.id',
							'service_types.name',
							'service_types.sortOrder',
							'service_types.locked',
							'service_types.created_at')
					->whereNull('service_types.deleted_at');

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
	}
	
	function save($params) {
		try {
			DB::beginTransaction();
			
			if(empty($params['id'])) {
				$id = null;
			}
			else {
				$id = $params['id'];
			}
			
			$type = ServiceType::firstOrNew([
				'id' => $id,
			]);
			
			$type->name = $params['name'];
			if(isset($params['locked'])) {
				$type->locked = 1;
			} else {
				$type->locked = 0;
			}
			
			$type->save();
		
			if (isset($params['image'])) {
				$image = $params['image'];
				$imageName = $id . microtime(true) . '.jpg';
				$image->move(public_path() . '/images', $imageName);
				$type->image = 'images/' . $imageName;
				
				$type->save();
			}
			
			DB::commit();
			return $type;
		} catch(\Exception $ex) {
			\Log::error("App\Actions\Management\ServiceTypeAction - save - " . $ex->getMessage());
			DB::rollBack();
			return null;
		}
	}
	
	public function lock($id) {
		$type = ServiceType::findOrFail($id);
		$type->locked = !$type->locked;
	
		$type->save();
		return $type;
	}
	
	public function remove($id){
		$type = ServiceType::findOrFail($id);
		$type->delete();
	}
	
}