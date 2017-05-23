<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;
use App\Service;
use App\ServiceApartment;

class ServiceAction {
	
	public function getJsonList($params) {
		//Khai báo mới dữ trả về
		$params['data'] = array();
		//Mảng của các thuộc tính(column) để hiển thị trên giao diện
		$columns = array(
				'id',
				'name',
				'providerName',
				'typeName'
		);
		//Lấy ra vị trí được sort
		$sortedIndex = $params['order']['column'];
	
		//Tạo query truy vấn
		$query = DB::table('services')
					->join('provider_service_types', 'provider_service_types.id', '=', 'services.provider_service_type_id')
					->join('service_types', 'service_types.id', '=', 'provider_service_types.service_type_id')
					->join('providers', 'providers.id', '=', 'provider_service_types.provider_id')
					->whereNull('services.deleted_at')
					->whereNull('provider_service_types.deleted_at')
					->whereNull('service_types.deleted_at')
					->whereNull('providers.deleted_at')
					->select(
								'services.id',
								'services.name',
								'services.locked',
								'service_types.name as typeName',
								'providers.name as providerName'
							);
		
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
	
	public function remove($id){
	
		$service = Service::findOrFail($id);
		$service->delete();
	}
	
	public function lock($id) {
	
		$service = Service::findOrFail($id);
		$service->locked = !$service->locked;
	
		$service->save();
		return $service;
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
			
			$service = Service::firstOrNew([
				'id' => $id,
			]);
			
			$service->name = $params['name'];
			$service->url = $params['url'];
			$service->phone = $params['phone'];
			$service->content = $params['content'];
			$service->start_at = $params['start_at'];
			$service->end_at = $params['end_at'];
			
			//Tìm id tương ứng trong table provider_service_types
			$query = DB::table('provider_service_types')
						->where('service_type_id', $params['service_type'])
						->where('provider_id', $params['provider'])
						->whereNull('provider_service_types.deleted_at');
			
			$tempItem = $query->get();
			
			if($tempItem->count() == 0) {
				return null;
			} else {
				$service->provider_service_type_id = $tempItem[0]->id;
			}
			
			
			if(isset($params['locked'])) {
				$service->locked = 1;
			} else {
				$service->locked = 0;
			}
			
			if(isset($params['re_call'])) {
				$service->re_call = 1;
			} else {
				$service->re_call = 0;
			}
			
			$service->save();
			
			if (isset($params['image'])) {
				$image = $params['image'];
				$imageName = $id . microtime(true) . '.jpg';
				$image->move(public_path() . '/images', $imageName);
				$service->image = 'images/' . $imageName;
				
				$service->save();
			}
			
			//Tiến hành thao tác với table service_aparments
			$this->saveServiceApartment($service->id, explode(",", $params['apartmentIds']));
			
			DB::commit();
			return $service;
		} catch (\Exception $ex) {
			\Log::error("App\Actions\Management\ServiceAction - save - " . $ex->getMessage());
			DB::rollBack();
			return null;
		}
	}
	
	/**
	 * tiến hành thao tác save cho bản service_apartments
	 *
	 * @param $serviceId: chua id cua nguoi cung cap
	 * @param $selected: Mang chua cac id cua service type
	 */
	private function saveServiceApartment($serviceId, $apartmentIds) {
		//Xóa tất cả các record của service Id trước đó
		$query = ServiceApartment::where('service_id', $serviceId)->delete();
	
		//Insert các dòng record mới
		foreach($apartmentIds as $id) {
			$item = new ServiceApartment();
			$item->service_id = $serviceId;
			$item->apartment_id = $id;
			$item->save();
		}
	}
}