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
use App\Block;
use App\Floor;
use App\Room;
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
			
			//Check Valid User
			$isValid = $loginAction->checkAuthentication($request->all());
			
			if(!$isValid) {
				return response()->json([
					'status' => false,
					'message' => Lang::get('main.invalid_user')
				]);
			} else {
				//checking user is enable or not
				$user = User::where('username', '=', $request->username)->first();
				if(!$user->is_enable) {
					return response()->json([
						'status' => false,
						'message' =>  Lang::get('main.unable_user')
					]);
				}

				return response()->json([
					'status' => true,
					'message' =>  $loginAction->getUserInfo($request->username)
				]);
			}
		} catch(\Exception $ex) {
			Log::error("App\Http\Controllers\Api\LoginController - checkAuthentication - " . $ex->getMessage());
			return response()->json([
				'status' => false,
				'message' => $ex->getMessage()
			]);
		}
	}
	
	public function register(Request $request)
	{
		//Lấy tất cả params của người dùng
		$params = $request->all();
		
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

	public function getApartments()
	{
		$apartments = Apartment::all();

		return response()->json([
			'items' => $apartments
		]);
	}

	public function getBlocks($departmentId)
	{
		$blocks = Block::where('apartment_id', $departmentId)->get();

		return response()->json([
			'items' => $blocks
		]);
	}

	public function getFloors($blockId)
	{
		$floors = Floor::where('block_id', $blockId)->get();

		return response()->json([
			'items' => $floors
		]);
	}

	public function getRooms($floorId)
	{
		$rooms = Room::where('floor_id', $floorId)->get();

		return response()->json([
			'items' => $rooms
		]);
	}
}
