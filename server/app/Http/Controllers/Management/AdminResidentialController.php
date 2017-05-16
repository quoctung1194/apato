<?php
namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Actions\Management\AdminResidentialAction;
use App\Admin;
use App\User;

class AdminResidentialController extends Controller {
    const PACKAGE = 'managements.adminResidentials';
    const MENU = 'MAR';

    private function view($view = null, $data = [], $mergeData = []) {
        $data['menu'] = $this::MENU;
        return view(self::PACKAGE . '.' . $view, $data, $mergeData);
    }

    public function showList() {
        return $this->view('showList');
    }

    public function getJsonList(Request $request) {
        $params = $request->all();
        $action = new AdminResidentialAction();
        $admin = auth()->guard('admin')->user();

        $params['order'] = $params['order'][0];
        $params['apartmentId'] = $admin->apartment_id;
        $message = $action->getJsonList($params);

        return response()->json($message);
    }

    function edit($id = -1) {
        $params = [];
        $admin = auth()->guard('admin')->user();
        $apartmentId = $admin->apartment_id;
        $action = new AdminResidentialAction();
        $params['apartmentId'] = $apartmentId;
        $params['floors'] = array();
        $params['rooms'] = array();

        //Khởi tạo đối tượng
        if($id == -1) {
            $user = new User();
        } else {
            $user = $action->getUserInfoById($id, $apartmentId);
            $blockId = $user->block_id;
            $floorId = $user->floor_id;
            $params['floors'] = $action->getListFloorById($apartmentId, $blockId);
            $params['rooms'] = $action->getListRoomById($apartmentId, $blockId, $floorId);
        }
        $params['user'] = $user;

        //Lấy ra danh sách blocks thuộc apartments
        $params['blocks'] = $action->getListBlockById($apartmentId);

        return $this->view('edit', $params);
    }

    public function remove(Request $request) {
        $action =  new AdminResidentialAction();
        $action->remove($request->id);
        
        return response()->json([
            'success' => true,
        ]);
    }

    public function lock(Request $request) {
        $action =  new AdminResidentialAction();
        $user = $action->lock($request->id);
    
        return response()->json([
            'success' => true,
            'locked' => $user->locked
        ]);
    }

    function save(Request $request) {
        $validates = [];
        $validates['last_name'] = 'required|max:45';
        $validates['first_name'] = 'required|max:45';
        $validates['phone'] = 'required|max:50';
        $validates['id_card'] = 'required|max:12';
        $validates['magnetic_card_code'] = 'required|max:50';
        $validates['population'] = 'required|numeric|min:1|max:255';
        $validates['birthday'] = 'required';
        $validates['block'] = 'required';
        $validates['floor'] = 'required';
        $validates['room'] = 'required';
        //$validates['start_at'] = 'required';
        $validates['note'] = 'required|max:1000';
        
        $validator = Validator::make($request->all(), $validates);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors);
        
            return response()->json([
                    'success' => false,
                    'message' => $errors
                    ]);
        }
        
        $action =  new AdminResidentialAction();
        $user = $action->save($request->all());
    
        if($user == null) {
            abort(500);
        }
        
        return response()->json([
            'success' => true,
            'id' => $user->id
        ]);
    }

    function getJsonFloorList(Request $request) {
        $params = $request->all();
        $action = new AdminResidentialAction();

        $apartmentId = $params['apartmentId'];
        $blockId = $params['blockId'];
        $list = $action->getListFloorById($apartmentId, $blockId);

        return response()->json($list);
    }

    function getJsonRoomList(Request $request) {
        $params = $request->all();
        $action = new AdminResidentialAction();

        $apartmentId = $params['apartmentId'];
        $blockId = $params['blockId'];
        $floorId = $params['floorId'];
        $list = $action->getListRoomById($apartmentId, $blockId, $floorId);

        return response()->json($list);
    }
}
