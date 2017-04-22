<?php
namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Actions\Management\AdminManagementAction;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller {
	
	const PACKAGE = 'managements.adminManagements';
	
	function edit() {
		$params = [];
		
		$adminManagementAction = new AdminManagementAction();
		$admin = auth()->guard('admin')->user();
		$apartments = $adminManagementAction->getApartmentsByAdmin($admin);
		
		$params['menu'] = 'MA';
		$params['apartments'] = $apartments;
		$params['admin'] = $admin;
		
		return $this->view('edit', $params);
	}
	
	function save(Request $request) {
		$admin = auth()->guard('admin')->user();
		$array = $request->all();
		
		$conditions = [
			'first_name' => 'required|max:45',
			'last_name' => 'required|max:45',
		];
		
		if ($admin->is_super_admin == '1') {
			$conditions['username'] = 'required|min:6|max:50';
			$conditions['apartment_id'] = 'required';
			$conditions['password1'] = 'required|min:6|max:100';
			$conditions['confirm_password1'] = 'required|same:password1';
			$conditions['password2'] = 'required|min:6|max:100';
			$conditions['confirm_password2'] = 'required|same:password2';
		} else {
			$array['id'] = $admin->id;
		}
		
		//Validate
		$validator = Validator::make($request->all(), $conditions);
		
		if ($admin->is_super_admin == '1') {
			$validator->after(function ($validator) {
				$params = $validator->getData();
				if (Admin::where('username', '=', $params['username'])->exists()) {
					$validator->errors()->add('username', 'The username has existed');
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
		
		$adminManagementAction = new AdminManagementAction();
		$admin = $adminManagementAction->save($array);
		
		$params['admin'] = $admin;
		
		return response()->json([
			'success' => true,
		]);
	}
	
	function editPassword1() {
		$params = [];
		
		$params['menu'] = 'MA';
		return $this->view('editPassword1', $params);
	}
	
	function updatePassword1(Request $request) {
		$action = new AdminManagementAction();
		
		$validator = Validator::make($request->all(), [
			'old_password' =>	'required|max:100',
			'new_password' =>	'required|min:6|max:100',
			'confirm_password' =>	'required|same:new_password',
		]);
		
		$validator->after(function ($validator) {
			$params = $validator->getData();
			$admin = auth()->guard('admin')->user();
			
			if (!\Hash::check($params['old_password'], $admin->password)) {
				$validator->errors()->add('old_password', 'Old password is incorrect');
			}
		});
		
		if ($validator->fails()) {
			$errors = $validator->errors();
			$errors = json_decode($errors);
				
			return response()->json([
					'success' => false,
					'message' => $errors
			]);
		}
		
		$admin = auth()->guard('admin')->user();
		$action->changePassword($admin->id, $request->new_password, false);
		
		return response()->json([
			'success' => true,
		]);
	}
	
	function editPassword2() {
		$params = [];
	
		$params['menu'] = 'MA';
		return $this->view('editPassword2', $params);
	}
	
	function updatePassword2(Request $request) {
		$action = new AdminManagementAction();
	
		$validator = Validator::make($request->all(), [
				'old_password' =>	'required|max:100',
				'new_password' =>	'required|min:6|max:100',
				'confirm_password' =>	'required|same:new_password',
		]);
	
		$validator->after(function ($validator) {
			$params = $validator->getData();
			$admin = auth()->guard('admin')->user();
				
			if (!\Hash::check($params['old_password'], $admin->password2)) {
				$validator->errors()->add('old_password', 'Old password is incorrect');
			}
		});
	
		if ($validator->fails()) {
			$errors = $validator->errors();
			$errors = json_decode($errors);

			return response()->json([
					'success' => false,
					'message' => $errors
			]);
		}

		$admin = auth()->guard('admin')->user();
		$action->changePassword($admin->id, $request->new_password, true);

		return response()->json([
				'success' => true,
		]);
	}
	
	private function view($view = null, $data = [], $mergeData = []) {
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
}