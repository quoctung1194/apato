<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Actions\Api\LoginAction;
use App\User;
use App\Apartment;
use Illuminate\Support\Facades\Lang;
use App\Actions\Api\App\Actions\Api;


class LoginController extends Controller {
	
	public function checkAuthentication(Request $request) {
		try {
			$loginAction = new LoginAction();
			
			//Check params
			$validator = Validator::make($request->all(), [
				'username' => 'required|Max:255',
				'password' => 'required|Max:255',
			]);
			if($validator->fails()) {
				return response()->json([
					'message' => -1
				]);
			}
			
			//Check Valid User
			$isValid = $loginAction->checkAuthentication($request->all());
			
			if(!$isValid) {
				return response()->json([
					'message' => -1
				]);
			} else {
				return response()->json([
					'message' =>  $loginAction->getUserInfo($request->username)
				]);
			}
		} catch(\Exception $ex) {
			Log::error("App\Http\Controllers\Api\LoginController - checkAuthentication - " . $ex->getMessage());
			return response()->json([
				'message' => -1
			]);
		}
	}
	
	public function register(Request $request)
	{
		//Lấy tất cả params của người dùng
		$params = $request->all();
		
		//Kiểm tra code có hợp lệ hay chưa
		$queryBuilder = Apartment::where('register_code', '=', $params['code']);
		if($queryBuilder->count() == 0)
		{
			$status = 'invalid';
			$message = Lang::get('main.invalid_code');
			
			return response()->json([
				'status' => $status,
				'message' => $message
			]);
		}
		else
		{
			$params['apartment'] = $queryBuilder->get()[0];
		}
		
		//Kiểm tra username có tồn tại hay không
		$queryBuilder = User::where('username', '=', $params['username']);
		if($queryBuilder->count() > 0)
		{
			$status = 'invalid';
			$message = Lang::get('main.invalid_username');
				
			return response()->json([
				'status' => $status,
				'message' => $message
			]);
		}
		
		//Kiểm tra phòng với chung cư tương ứng có tồn tai hay không
		$queryBuilder = DB::table('apartments')
					->join('blocks', 'blocks.apartment_id', '=', 'apartments.id')
					->join('floors', 'floors.block_id', '=', 'blocks.id')
					->join('rooms', 'rooms.floor_id', '=', 'floors.id')
					
					->whereNull('apartments.deleted_at')
					->whereNull('blocks.deleted_at')
					->whereNull('floors.deleted_at')
					->whereNull('rooms.deleted_at')
					->where('rooms.name', 'like', $params['room'])
					->where('apartments.id', '=', $params['apartment']->id);
		if($queryBuilder->count() == 0)
		{
			$status = 'invalid';
			$message = Lang::get('main.invalid_room');
			
			return response()->json([
				'status' => $status,
				'message' => $message
			]);
		}
		else
		{
			$params['room_id'] = $queryBuilder->first()->id;
		}
		
		$action = new LoginAction();
		$result = $action->register($params);
		
		if($result)
		{
			$status = 'successful';
			$message = Lang::get('main.successful');
				
			return response()->json([
				'status' => $status,
				'message' => $message
			]);
		}
		else
		{
			$status = 'invalid';
			$message = Lang::get('main.invalid_register');
			
			return response()->json([
				'status' => $status,
				'message' => $message
			]);
		}
	}
}
