<?php
namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Actions\Management\ApartmentAction;

class ApartmentController extends Controller {
	
	const PACKAGE = 'managements.apartments';
	
	public function getJsonApartmentDetail($id) {
		$params = [];
		
		$apartmentAction =  new ApartmentAction();
		$apartment = $apartmentAction->getApartmentDetail($id);
		
		return response()->json([
			'apartment' => $apartment
		]);
	}
	
	private function view($view = null, $data = [], $mergeData = []) {
		return view(self::PACKAGE . '.' . $view, $data, $mergeData);
	}
}