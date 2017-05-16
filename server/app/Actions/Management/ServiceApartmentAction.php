<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;

class ServiceApartmentAction {
	
	public function getList($conditions = null, $cols = null) {
	
		$query = DB::table('service_apartments')
		->join('services', 'services.id', '=', 'service_apartments.service_id')
		->join('apartments', 'apartments.id', '=', 'service_apartments.apartment_id')
		->whereNull('services.deleted_at')
		->whereNull('apartments.deleted_at');
	
		if($conditions != null) {
			$query->where($conditions);
		}
	
		if($cols == null) {
			return $query->select('service_apartments.*')->get();
		} else {
			foreach($cols as $col) {
				$query->addSelect($col);
			}
				
			return $query->get();
		}
	}
	
}
