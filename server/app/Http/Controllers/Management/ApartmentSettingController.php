<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Actions\Management\ApartmentSettingAction;
use App\Admin;
use App\Apartment;

class ApartmentSettingController extends Controller {
    const PACKAGE = 'managements.apartmentSettings';
    const MENU = 'MAS';

    private function view($view = null, $data = [], $mergeData = []) {
        $data['menu'] = $this::MENU;
        return view(self::PACKAGE . '.' . $view, $data, $mergeData);
    }

    public function edit() {
        $params = [];
        $admin = auth()->guard('admin')->user();
        $apartmentId = $admin->apartment_id;
        $action = new ApartmentSettingAction();
        $apartment = new Apartment();

        //Khởi tạo đối tượng
        $apartment = $action->getApartmentInfoById($apartmentId);
        $provinceId = $apartment->province_id;
        $districtId = $apartment->district_id;

        $params['apartment'] = $apartment;
        $params['provinces'] = $action->getListProvince();
        $params['districts'] = $action->getListDistrictById($provinceId);
        $params['wards'] = $action->getListWardById($districtId);
        $params['statistics'] = $action->getStatistic($apartmentId);

        return $this->view('edit', $params);
    }

    public function save(Request $request) {
        $validates = [];
        $validates['apartment_name'] = 'required|max:255';
        $validates['address'] = 'required|max:255';
        $validates['employer_name'] = 'required|max:255';
        $validates['complete_year'] = 'required|regex:/[0-9]{4}/';
        $validates['province'] = 'required';
        $validates['district'] = 'required';
        $validates['ward'] = 'required';
        
        $validator = Validator::make($request->all(), $validates);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors);
       
             return response()->json([
                    'success' => false,
                    'message' => $errors
                    ]);
        }
        
        $action = new ApartmentSettingAction();
        $apartment = $action->save($request->all()); 
   
        if($apartment == null) {
            abort(500);
        }
        
        return response()->json([
            'success' => true,
            'id' => $apartment->id
        ]);
    }

    function getJsonDistrictList(Request $request) {
        $params = $request->all();
        $action = new ApartmentSettingAction();

        $province_id = $params['province_id'];
        $list = $action->getListDistrictById($province_id);

        return response()->json($list);
    }

    function getJsonWardList(Request $request) {
        $params = $request->all();
        $action = new ApartmentSettingAction();

        $district_id = $params['district_id'];
        $list = $action->getListWardById($district_id);

        return response()->json($list);
    }
}
