<?php
namespace App\Actions\Management;

class LoginAction {
	
	public function isValid($credentials) {
		$auth = auth()->guard('admin');
	
		if ($auth->attempt($credentials)) {
			return true;
		}
	
		return false;
	}
	
	public function logout() {
		$auth = auth()->guard('admin');
		$auth->logout();
	}
	
}