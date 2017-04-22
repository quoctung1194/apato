<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;

class ProviderServiceTypeAction {
	
	public function getList($conditions = null, $cols = null) {
	
		$query = DB::table('provider_service_types')
					->join('service_types', 'service_types.id', '=', 'provider_service_types.service_type_id')
					->join('providers', 'providers.id', '=', 'provider_service_types.provider_id')
					->whereNull('provider_service_types.deleted_at')
					->whereNull('service_types.deleted_at')
					->whereNull('providers.deleted_at');
	
		if($conditions != null) {
			$query->where($conditions);
		}
		
		if($cols == null) {
			return $query->select('providers.*')->get();
		} else {
			foreach($cols as $col) {
				$query->addSelect($col);
			}
			
			return $query->get();
		}
	}
	
}