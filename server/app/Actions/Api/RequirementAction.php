<?php
namespace App\Actions\Api;

use App\Requirement;
use App\RequirementImage;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RequirementAction {
	
	function save($params, $userId) {
		try {
			DB::beginTransaction();
			$requirement = new Requirement();
			
			$requirement->type_id = $params['selectedIndexType'];
			$requirement->tag_id = $params['selectedIndexTag'];
			$requirement->title = $params['title'];
			$requirement->description = $params['description'];
			$requirement->is_repeat_problem = $params['repeatProblem'];
			$requirement->user_id = $userId;
			
			$requirement->save();
			
			$images = array();
			if(isset($params['images'])) {
				$images = $params['images'];
			}
			foreach ($images as $image) {
				$data = new RequirementImage();
				
				$data->path = "";
				$data->requirement_id = $requirement->id;
				$data->save();
			
				$imageName = $data->id . microtime(true) . '.' . $image->getClientOriginalExtension();
				$image->move(public_path() . '/images', $imageName);
				$data->path = 'images/' . $imageName;
			
				$data->save();
			}
			
			DB::commit();
			return true;
		} catch(\Exception $ex) {
			Log::error("RequirementAction - save - " . $ex->getMessage());
			DB::rollBack();
			return false;
		}
	}
	
}