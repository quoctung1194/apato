<?php
namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Actions\Management\LoginAction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller {
	
	const PACKAGE = 'managements';
	
	function show() {
		return $this->view('login');
	}
	
	function login(Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');
		$loginAction = new LoginAction();
		
		$credentials = [
			'username' => $username,
			'password' => $password,
		];
		
		if ($loginAction->isValid($credentials)) {
			$admin = auth()->guard('admin')->user();
			if($admin->is_super_admin == 0) {
				return redirect()->route('MM-001');
			} else {
				return redirect()->route('MSET-001');
			}
		} else {
			return redirect()->route('ML-001');
		}
	}
	
	function logout() {
		$loginAction = new LoginAction();
		$loginAction->logout();
		
		return redirect()->route('ML-001');
	}
	
	private function view($view = null, $data = [], $mergeData = []) {
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
	
}