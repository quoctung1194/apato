<?php
namespace App\Actions\Management;

use App\Apartment;
use Illuminate\Support\Facades\DB;

class ApartmentAction {
	
	public function getApartmentDetail($id) {
		$apartment = Apartment::findOrFail($id);
		return $apartment;
	}
	
	public function getList($conditions = null) {
	
		$query = DB::table('apartments')
					->whereNull('deleted_at');
	
		if($conditions != null) {
			$query->where($conditions);
		}
		
		return $query->orderBy('name', 'asc')->get();
	}
}