<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;

use App\Apartment;
use App\Admin;

class AdminManagementAction {
	
	public function getApartmentsByAdmin($admin) {
	
		$query = DB::table('apartments');
	
		if(!empty($admin->id) && $admin->is_super_admin=='0') {
			$query->join('admins', 'admins.apartment_id', '=', 'apartments.id')
			->where('admins.id', '=', $admin->id);
		}
	
		return $query->orderBy('apartments.id', 'desc')->get();
	}
	
	public function save($params) {
		
		if(empty($params['id']))
		{
			$id = null;
		}
		else
		{
			$id = $params['id'];
		}
		$admin = Admin::firstOrNew([
				'id' => $id,
		]);
		
		$admin->first_name = $params['first_name'];
		$admin->last_name = $params['last_name'];

		if ($id == null) {
			$admin->username = $params['username'];
			$admin->password = \Hash::make($params['password1']);
			$admin->password2 = \Hash::make($params['password2']);
			$admin->email = $params['username'];
			$admin->is_super_admin = '0';
			$admin->apartment_id = $params['apartment_id'];
		}
		
		$admin->save();
	}
	
	public function changePassword($userId, $password, $isPassword2) {
		$admin = Admin::findOrFail($userId);
		$typeOfPassword = '';
		
		if($isPassword2) {
			$typeOfPassword = 'password2';
		} else {
			$typeOfPassword = 'password';
		}
		
		$admin->$typeOfPassword = \Hash::make($password);
		$admin->save();
	}
}