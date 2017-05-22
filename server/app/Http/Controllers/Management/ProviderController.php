<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Provider;
use App\Http\Controllers\Controller;
use App\Actions\Management\ProviderAction;
use App\Actions\Management\App\Actions\Management;
use App\Actions\Management\ServiceTypeAction;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller {
	
	const PACKAGE = 'managements.providers';
	const MENU = 'MSEP';
	
	public function showList() {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		return $this->view('showList');
	}
	
	public function edit($id = -1) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();

		$params = [];
		
		//Khởi tạo đối tượng
		if($id == -1) {
			$provider = new Provider();
		} else {
			$provider = Provider::findOrFail($id);
		}
		$params['provider'] = $provider;
		
		//Lấy danh sách tất cả các loại dịch vụ
		$serviceTypeAction = new ServiceTypeAction();
		//Điều kiện custom
		$conditions = function($query) {
			$query->where('locked', '=', '0');
		};
		$serviceTypes = $serviceTypeAction->getList($conditions);
		$params['serviceTypes'] = $serviceTypes;
		
		//Lấy ra danh sách tất cả các loại dịch vụ của provider hiện hành
		$params['typesOfProvider'] = array();
		if($id != -1) {
			$action =  new ProviderAction();
			$params['typesOfProvider'] = $action->getServiceTypesByProviderId($id);
		}
		return $this->view('edit', $params);
	}
	
	public function getJsonList(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
	
		$params = $request->all();
		$action =  new ProviderAction();
	
		$params['order'] = $params['order'][0];
		$message = $action->getJsonList($params);
	
		return response()->json($message);
	}
	
	public function remove(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		
		$action =  new ProviderAction();
		$action->remove($request->id);
		
		return response()->json([
			'success' => true,
		]);
	}
	
	public function lock(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		
		$action =  new ProviderAction();
		$provider = $action->lock($request->id);
		
		return response()->json([
			'success' => true,
			'locked' => $provider->locked
		]);
	}
	
	public function save(Request $request) {
		//Kiểm tra có phải super admin hay không
		$this->checkIsSuperAdmin();
		//Kiểm tra validate
		$validates = [];
		
		$validates['name'] = 'required|min:6|max:100';
		$validates['services'] = 'required';		
		$validator = Validator::make($request->all(), $validates);
		
		//Kiểm tra trùng tên
		$name = '';
		if (!empty($request->id)) {
			$providerTmp = DB::table('providers')
							->where('id', '=', $request->id)
							->get();
			$name = $providerTmp[0]->name;
		}
		
		if ($request->name <> $name) {
			$validator->after(function($validator) {
				$params = $validator->getData();
				if (Provider::where('name', '=', $params['name'])->exists()) {
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
		
		$action =  new ProviderAction();
		$provider = $action->save($request->all());
		
		if($provider == null) {
			abort(500);
		}
		
		return response()->json([
			'success' => true,
			'id' => $provider->id
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