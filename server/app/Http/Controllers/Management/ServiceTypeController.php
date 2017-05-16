<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\ServiceType;
use App\Http\Controllers\Controller;
use App\Actions\Management\ServiceTypeAction;
use App\Actions\Management\App\Actions\Management;

class ServiceTypeController extends Controller {
	
	const PACKAGE = 'managements.serviceTypes';
	const MENU = 'MSET';
	
	public function showList() {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$params = [];
		$action =  new ServiceTypeAction();
		$params['types'] = $action->getList();
	
		return $this->view('showList', $params);
	}
	
	public function edit($id = -1) {
		$this->checkIsSuperAdmin();

		$params = [];
		
		if($id == -1) {
			$serviceType = new ServiceType();
		} else {
			$serviceType = ServiceType::findOrFail($id);
		}
		
		$params['serviceType'] = $serviceType;
		return $this->view('edit', $params);
	}
	
	public function getJsonList(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$params = $request->all();
		$action =  new ServiceTypeAction();
	
		$params['order'] = $params['order'][0];
		$message = $action->getJsonList($params);
	
		return response()->json($message);
	}
	
	public function remove(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$action =  new ServiceTypeAction();
		$action->remove($request->id);
	
		return response()->json([
			'success' => true,
		]);
	}
	
	public function lock(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$action =  new ServiceTypeAction();
		$type = $action->lock($request->id);
	
		return response()->json([
			'success' => true,
			'locked' => $type->locked
		]);
	}
	
	public function save(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$validates = [];
		$validates['name'] = 'required|min:6|max:100';
		if ($request['id'] == '' || isset($request['image'])) {
			$validates['image'] = 'mimes:bmp,png,gif,jpeg|required|max:300';
		}
		
		$validator = Validator::make($request->all(), $validates);
		
		//Kiểm tra trùng tên
		$name = '';
		if ($request['id'] <> '') {
			$typeTmp = DB::table('service_types')
			->where('id', '=', $request['id'])
			->get();
			$name = $typeTmp[0]->name;
		}
		
		if ($request['name'] <> $name) {
			$validator->after(function($validator) {
				$params = $validator->getData();
				if (ServiceType::where('name', '=', $params['name'])->exists()) {
					$validator->errors()->add('name', 'The name has existed');
				}
			});
		}
		
		if ($validator->fails()) {
			$errors = $validator->errors();
			$errors = json_decode($errors);
		
			return response()->json([
					'success' => false,
					'message' => $errors
					]);
		}
		
		$action =  new ServiceTypeAction();
		$type = $action->save($request->all());
	
		if($type == null) {
			abort(500);
		}
		
		return response()->json([
			'success' => true,
			'id' => $type->id
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