<?php
namespace App\Actions\Api;

use App\ServiceType;
use App\Service;

use Illuminate\Support\Facades\DB;

class ServiceAction {
	
	public function getTypes() {
		
		$query = ServiceType::whereNull('deleted_at')
							->where('locked', '0');
		
		return $query->orderBy('name', 'asc')->get();
	}
	
	public function getList($serviceType = -1, $apartmentId = -1) {
		$query = DB::table('services')
					->join('provider_service_types', 'provider_service_types.id', '=', 'services.provider_service_type_id')
					->join('service_apartments', 'service_apartments.service_id', '=', 'services.id')
					->join('service_types', 'service_types.id', '=', 'provider_service_types.service_type_id')
					->join('providers', 'providers.id', '=', 'provider_service_types.provider_id')
					
					->where('services.locked', '=', 0)
					->where('service_types.locked', '=', 0)
					->where('providers.locked', '=', 0)
					
					->whereNull('services.deleted_at')
					->whereNull('service_types.deleted_at')
					->whereNull('providers.deleted_at');
		
		if($apartmentId != -1) {
			$query = $query->where('service_apartments.apartment_id', '=', $apartmentId);
		}
		if($serviceType != -1) {
			$query = $query->where('service_types.id', '=', $serviceType);
		}
		
		return $query->orderBy('provider_service_types.provider_id', 'asc')
				->select('services.*')
				->get();
	}
	
}