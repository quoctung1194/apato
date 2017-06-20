<?php
namespace App\Actions\Api;

use App\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LoginAction {
	
	function checkAuthentication($params) {
		try {
			
			//Check authentication
			$username = $params['username'];
			$password = $params['password'];
			
			$user = User::where('username', '=', $username);
			
			if($user->count() == 0) {
				return false;
			}
			
			if(\Hash::check($password, $user->first()->password) > 0) {
				return true;
			}
			return false;
			
		} catch (\Exception $ex) {
			Log::error("App\Actions\Api\LoginAction - checkAuthentication - " . $ex->getMessage());
			return false;
		}
	}
	
	function getUserInfo($username) {
		try {
			$query = DB::table('users')
						->select
						(
							'users.id as userId',
							'users.username as username',
							'users.api_token as apiToken',
							'apartments.id as apartmentId',
							'apartments.name as apartmentName',
							'blocks.id as blockId',
							'floors.id as floorId',
							'rooms.id as roomId'
						)
						->join('rooms', 'rooms.id', '=', 'users.room_id')
						->join('floors', 'floors.id', '=', 'rooms.floor_id')
						->join('blocks', 'blocks.id', '=', 'floors.block_id')
						->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')
						
						->whereNull('users.deleted_at')
						->whereNull('rooms.deleted_at')
						->whereNull('floors.deleted_at')
						->whereNull('blocks.deleted_at')
						->whereNull('apartments.deleted_at')
						
						->where('users.username', $username);
			
			$user = $query->first();
			
			return $user;
		} catch(\Exception $ex) {
			Log::error("App\Actions\Api\LoginAction - getUserInfo - " . $ex->getMessage());
			return null;
		}
	}
	
	function register($params)
	{
		$user = new User();
		$user->first_name = $params['first_name'];
		$user->last_name = $params['last_name'];
		$user->password = \Hash::make($params['password']);
		$user->username = $params['username'];
		$user->room_id = $params['room_id'];
		$user->email = $params['email'];
		$user->api_token = str_random(60);
		$user->is_enable = false;

		return $user->save();
	}
}

