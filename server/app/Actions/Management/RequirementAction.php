<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Apartment;
use App\Setting;
use App\User;
use App\Requirement;

class RequirementAction {	
	
	 public function showList($apartmentId) {
	 	try {
	 		
			$requirements = DB::table('requirements')
			->join('users', 'users.id', '=', 'requirements.user_id')
			->join('rooms', 'rooms.id', '=', 'users.room_id')
			->join('floors', 'floors.id', '=', 'rooms.floor_id')
			->join('blocks', 'blocks.id', '=', 'floors.block_id')
			->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')
			->select('requirements.*')
			->where('apartments.id', '=', $apartmentId)
			->orderBy('requirements.id', 'desc')
			->get();
			
			//Get Setting
			$setting = Setting::where([
				['apartment_id', '=', $apartmentId],
			])->first();
				
			$types = $setting->getTypes();
			$tags = $setting->getTags();
				
			foreach($requirements as $requirement) {
				$tag = $this->getTagById($requirement->tag_id, $tags);
				$type = $this->getTypeById($requirement->type_id, $types);
				$account = User::findOrFail($requirement->user_id);
				
				$requirement->tagContent = $tag->content;
				$requirement->typeContent = $type->content;
				$requirement->account = $account->username;
			}
			
			return $requirements;
	 	} catch(\Exception $ex) {
	 		Log::error("App\Actions\Management\RequirementAction - showList - " . $ex->getMessage());
			return array();
		}
	}
	
	function getTagById($requirementId, $tags) {
		foreach($tags as $tag) {
			if($tag->id == $requirementId) {
				return $tag;
			}
		}
		
		return null;
	}
	
	function getTypeById($requirementId, $types) {
		foreach($types as $type) {
			if($type->id == $requirementId) {
				return $type;
			}
		}
		
		return null;
	}
	
	function getRequirement($id) {
		try {
			$requirement = Requirement::findOrFail($id);
			
			//Get Setting
			$admin = auth()->guard('admin')->user();
			$setting = Setting::where([
					['apartment_id', '=', $admin->apartment_id],
			])->first();
				
			$types = $setting->getTypes();
			$tags = $setting->getTags();
			
			$tag = $this->getTagById($requirement->tag_id, $tags);
			$type = $this->getTypeById($requirement->type_id, $types);
			$account = User::findOrFail($requirement->user_id);
			
			$requirement->tagContent = $tag->content;
			$requirement->typeContent = $type->content;
			$requirement->account = $account->username;
			
			return $requirement;
		} catch(\Exception $ex) {
			Log::error("App\Actions\Management\RequirementAction - getRequirement - " . $ex->getMessage());
			return array();
		}
	}
	
}