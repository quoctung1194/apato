<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Actions\Management\ServiceAction;
use App\Service;
use App\Actions\Management\App\Actions\Management;
use App\Actions\Management\ServiceTypeAction;
use App\Actions\Management\ProviderAction;
use App\Actions\Management\ApartmentAction;
use App\Actions\Management\ServiceClickAction;
use Illuminate\Support\Facades\DB;
use App\Actions\Management\ProviderServiceTypeAction;
use App\Actions\Management\ServiceApartmentAction;

class ServiceController extends Controller {
	
	const PACKAGE = 'managements.services';
	const MENU = 'MSE';
	
	public function showList() {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		return $this->view('showList');
	}
	
	public function getJsonList(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$params = $request->all();
		$action =  new ServiceAction();
	
		$params['order'] = $params['order'][0];
		$message = $action->getJsonList($params);
	
		return response()->json($message);
	}
	
	public function remove(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$action =  new ServiceAction();
		$action->remove($request->id);
	
		return response()->json([
			'success' => true,
		]);
	}
	
	public function lock(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$action =  new ServiceAction();
		$provider = $action->lock($request->id);
	
		return response()->json([
			'success' => true,
			'locked' => $provider->locked
		]);
	}
	
	public function edit($id = -1) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		$params = array();
		
		//Lấy ra service hiện hành
		if($id == -1) {
			$service = new Service();
		} else {
			$service = Service::findOrFail($id);
		}
		$params['service'] = $service;
		
		//Lấy ra danh sách loại dịch vụ
		$serviceTypeAction = new ServiceTypeAction();
		$params['serviceTypes'] = $serviceTypeAction->getList();
		
		//Lấy ra danh sách chung cư
		$apartmentAction = new ApartmentAction();
		$params['apartments'] = $apartmentAction->getList();
		
		if($id != -1) {
			//Lấy tổng số click đến hiện hành
			$serviceClickAction = new ServiceClickAction();
			$service->totalClick = $serviceClickAction->getTotalClickByService($service->id);
			
			//Lấy id nhà cung cấp và loại dịch vụ tương ứng ra
			$cols = ["provider_service_types.provider_id", "provider_service_types.service_type_id"];
			//Truyền điều kiện
			$conditions = function ($query) use ($service) {
				$query->where('provider_service_types.id', $service->provider_service_type_id);
			};
			$providerServiceTypeAction = new ProviderServiceTypeAction();
			//Lấy kết quả
			$result = $providerServiceTypeAction->getList($conditions, $cols);
			//Gán kết quả vào đối tượng hiện hành
			$service->selectedServiceType = $result[0]->service_type_id;
			$service->selectedProvider = $result[0]->provider_id;
			
			//Lấy danh sách nhà cung cấp tương ứng với loại dịch vụ
			$result = $providerServiceTypeAction->getList();
			//Truyền điều kiện
			$conditions = function ($query) use ($service) {
				$query->where('provider_service_types.service_type_id', $service->selectedServiceType);
			};
			//Lấy kết quả
			$params['providers'] = $providerServiceTypeAction->getList($conditions);
			
			//Lấy ra danh sách tất cả các chung cư của dịch vụ hiện hành
			$serviceApartmentAction =  new ServiceApartmentAction();
			//Điều kiện
			$conditions = function ($query) use($service) {
				$query->where('services.id', $service->id);
			};
			//Column select
			$cols = ['apartments.id as id', 'apartments.name as name'];
			$params['selectedApartments'] = $serviceApartmentAction->getList($conditions, $cols);
		}
		
		return $this->view('edit', $params);
	}
	
	public function getClickJsonList(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		
		//Lấy ra danh sách click
		$serviceClickAction = new ServiceClickAction();
		//Lấy ra danh sách click
		$params = $request->all();
		$params['order'] = $params['order'][0];
	
		//Lấy dữ liệu tương ứng
		$list = $serviceClickAction->getClickListByService($params);
		//Đỗ dữ liệu ra json
		return response()->json($list);
	}
	
	public function save(Request $request) {
		$this->checkIsSuperAdmin();
		
		$validates = [];
		$validates['name'] = 'required|min:6|max:100';
		$validates['url'] = 'required|max:500';
		$validates['phone'] = 'max:50';
		$validates['content'] = 'required|max:1000';
		$validates['service_type'] = 'required';
		$validates['provider'] = 'required';
		$validates['start_at'] = 'required';
		$validates['end_at'] = 'required';
		$validates['apartmentIds'] = 'required';
		
		if ($request['id'] == '' || isset($request['image'])) {
			$validates['image'] = 'mimes:bmp,png,gif,jpeg|required|max:300';
		}
		
		$validator = Validator::make($request->all(), $validates);
		
// 		//Kiểm tra trùng tên
// 		$name = '';
// 		if (!empty($request->id)) {
// 			$serviceTmp = DB::table('services')
// 							->where('id', '=', $request->id)
// 							->get();
// 			$name = $serviceTmp[0]->name;
// 		}
		
// 		if ($request->name <> $name) {
// 			$validator->after(function($validator) {
// 				$params = $validator->getData();
// 				if (Service::where('name', '=', $params['name'])->exists()) {
// 					$validator->errors()->add('name', 'The name has existed');
// 				}
// 			});
// 		}
		
		if ($validator->fails()) {
			$errors = $validator->errors();
			$errors = json_decode($errors);
		
			return response()->json([
					'success' => false,
					'message' => $errors
			]);
		}
		
		$action = new ServiceAction();
		$service = $action->save($request->all());
		
		if($service == null) {
			abort(500);
		}
		
		return response()->json([
			'success' => true,
			'id' => $service->id
		]);
	}
	
	private function checkIsSuperAdmin() {
		$admin = auth()->guard('admin')->user();
	
		if ($admin->is_super_admin == 0) {
			abort(403);
		}
	}
	
	private function view($view = null, $data = [], $mergeData = []) {
		$data['menu'] = $this::MENU;
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
}