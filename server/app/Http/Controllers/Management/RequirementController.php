<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Actions\Management\RequirementAction;

use App\Setting;
use App\Requirement;

class RequirementController extends Controller {
    
    const PACKAGE = 'managements.requirements';
    const MENU = 'MR';
    
    function showList() {
        try {
            $result = array();
            $admin = auth()->guard('admin')->user();
            
            $requirementAction = new RequirementAction();
            $list = $requirementAction->showList($admin->apartment->id);
            
            $result['requirements'] =  $list;
            
            return $this->view('showList', $result);
        } catch (\Exception $ex) {
            Log::error("App\Http\Controllers\Management\RequirementController - showList - " . $ex->getMessage());
        }
    }
    
    function edit($id = -1) {
        $result = array();
        
        //Get Setting
        $admin = auth()->guard('admin')->user();
        $setting = Setting::where([
                ['apartment_id', '=', $admin->apartment_id],
        ])->first();
        $result['types'] = $setting->getTypes();
        $result['tags'] = $setting->getTags();
        $requirementAction = new RequirementAction();
        
        //Khởi tạo đối tượng
        if($id == -1) {
            $requirement = new Requirement();
            $requirement->user_id = $admin->id;
        } else {
            $requirement = $requirementAction->getRequirement($id);
        }
        $result['requirement'] = $requirement;
        return $this->view('edit', $result);
    }

    public function getJsonList(Request $request) {
        $params = $request->all();
        $action = new RequirementAction();
        $admin = auth()->guard('admin')->user();

        $params['order'] = $params['order'][0];
        $params['apartmentId'] = $admin->apartment_id;
        $message = $action->getJsonList($params);

        return response()->json($message);
    }

    function save(Request $request) {
        $validates = [];
        $validates['title'] = 'required|max:255';
        $validates['created_at'] = 'required|date';
        $validates['type'] = 'required|numeric';
        $validates['tag'] = 'required|numeric';
        $validates['is_repeat_problem'] = 'required|boolean';
        $validates['description'] = 'required|string|max:1000';
        
        $validator = Validator::make($request->all(), $validates);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors);
       
             return response()->json([
                'success' => false,
                'message' => $errors
            ]);
        }
        
        $action =  new RequirementAction();
        $requirement = $action->save($request->all()); 
   
        if($requirement == null) {
            abort(500);
        }
        
        return response()->json([
            'success' => true,
            'id' => $requirement->id
        ]);
    }

    public function remove(Request $request) {
        $action =  new RequirementAction();
        $action->remove($request->id);
        
        return response()->json([
            'success' => true,
        ]);
    }

    public function lock(Request $request) {
        $action =  new RequirementAction();
        $requirement = $action->lock($request->id);
    
        return response()->json([
            'success' => true,
            'locked' => $requirement->locked
        ]);
    }
    
    private function view($view = null, $data = [], $mergeData = []) {
        $data['menu'] = $this::MENU;
        return view(self::PACKAGE . '.' . $view, $data, $mergeData);
    }
}