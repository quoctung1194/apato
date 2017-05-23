<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;
use App\Provider;
use App\ProviderServiceType;

class ProviderAction {
	
	public function getList($conditions = null) {
	
		$query = DB::table('providers')
					->whereNull('deleted_at');
	
		if($conditions != null) {
			$query->where($conditions);
		}
		
		return $query->orderBy('name', 'asc')->get();
	}
	
	public function getServiceTypesByProviderId($providerId = -1) {
		$query = DB::table('providers')
					->join('provider_service_types', 'providers.id', '=', 'provider_service_types.provider_id')
					->join('service_types', 'service_types.id', '=', 'provider_service_types.service_type_id')
					//->where('service_types.locked', '=', '0')
					->where('providers.id', '=', $providerId)
					->whereNull('service_types.deleted_at')
					->whereNull('providers.deleted_at')
					->whereNull('provider_service_types.deleted_at');
		
		return $query->orderBy('service_types.created_at', 'desc')->get();
	}
	
	public function getJsonList($params) {
		//Khai báo mới dữ trả về
		$params['data'] = array();
		//Mảng của các thuộc tính(column) để hiển thị trên giao diện
		$columns = array(
				'id',
				'name',
				'none',
				'created_at'
		);
		//Lấy ra vị trí được sort
		$sortedIndex = $params['order']['column'];
	
		//Tạo query truy vấn
		$query = DB::table('providers')
					->whereNull('deleted_at');
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
	
	public function lock($id) {
		
		$provider = Provider::findOrFail($id);
		$provider->locked = !$provider->locked;
		
		$provider->save();
		return $provider;
	}
	
	public function save($params) {
		try {
			DB::beginTransaction();
			
			if(empty($params['id'])) {
				$id = null;
			}
			else {
				$id = $params['id'];
			}
			$provider = Provider::firstOrNew([
				'id' => $id,
			]);
			
			$provider->name = $params['name'];
			if(isset($params['locked'])) {
				$provider->locked = 1;
			} else {
				$provider->locked = 0;
			}
			
			$provider->save();
			
			//Tiến hành thao tác với table provider_service_types
			$this->saveProviderServiceType($provider->id, explode(",", $params['services']));
			
			DB::commit();
			return $provider;
		} catch (\Exception $ex) {
			\Log::error(" App\Actions\Management\ProviderAction - save - " . $ex->getMessage());
			DB::rollBack();
			return null;
		}
	}
	
	/**
	 * tiến hành thao tác save cho bản provider_service_types
	 * 
	 * @param $providerId: chua id cua nguoi cung cap
	 * @param $serviceTypeIds: Mang chua cac id cua service type
	 */
	private function saveProviderServiceType($providerId, $serviceTypeIds) {
		//Danh sách dịch vụ ban đầu của provider này
		$initServices = $this->getServiceTypesByProviderId($providerId);
		//Chuyển sang array id
		$initServiceIds = array();
		foreach($initServices as $service) {
			$initServiceIds[] = $service->id;
		}
		
		//Kiểm tra các id mới có nằm trong mảng $initServiceIds hay không
		foreach($serviceTypeIds as $id) {
			if(!in_array ($id, $initServiceIds)) {
				$item = new ProviderServiceType();
				$item->provider_id = $providerId;
				$item->service_type_id = $id;
				$item->save();
			} else {
				//Xóa các id đã tồn tại trong mảng $initServiceIds
				$index = array_search($id, $initServiceIds);
				unset($initServiceIds[$index]);
			}
		}
		
		//Xóa các phần tử dư thừa trong $initServiceIds
		foreach($initServiceIds as $id) {
			ProviderServiceType::where('provider_id', $providerId)
								->where('service_type_id', $id)
								->delete();
		}
	}
	
	public function remove($id){
		
		$provider = Provider::findOrFail($id);
		$provider->delete();
	}
}