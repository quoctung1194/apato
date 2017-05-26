<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;
use App\User;

class AdminResidentialAction {

    public function getJsonList($params) {
        //Khai báo mới dữ trả về
        $params['data'] = array();

        //Mảng của các thuộc tính(column) để hiển thị trên giao diện
        $columns = array(
                'none',
                'first_name',
                'last_name',
                'block_name',
                'floor_name',
                'room_name',
                'none',
        );

        //Lấy ra vị trí được sort
        $sortedIndex = $params['order']['column'];

        //Tạo query truy vấn
        $query = DB::table('users')
                    ->select('users.id as userId',
                            'users.first_name',
                            'users.last_name',
                            'users.locked',
                            'blocks.name as block_name',
                            'floors.name as floor_name',
                            'rooms.name as room_name')
                    ->join('rooms', 'rooms.id', '=', 'users.room_id')
                    ->join('floors', 'floors.id', '=', 'rooms.floor_id')
                    ->join('blocks', 'blocks.id', '=', 'floors.block_id')
                    ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')
                    ->whereNull('users.deleted_at')
                    ->whereNull('rooms.deleted_at')
                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')
                    ->whereNull('apartments.deleted_at')
                    ->where('apartments.id', '=', $params['apartmentId']);

        //Tổng số record PHÙ HỢP trong database
        $params['recordsTotal'] = $query->count();

        //Tổng số record ĐƯỢC LỌC VÀ PHÙ HỢP trong database
        $params['recordsFiltered'] = $query->count();

        //Danh sách item hiển thị trên màn hình tại vị trí trang tương ứng
        $params['data'] = $query->skip($params['start'])
        ->take($params['length'])
        ->orderBy(
                $columns[$sortedIndex],
                $params['order']['dir']
        )
        ->get();

        //Tạo số thứ tự, đối với phân trang ở client thì có common làm sẵn
        //ko cần làm bước này ở server
        $count = $params['start'];
        foreach($params['data'] as $item) {
            $item->stt = ++$count;
        }

        return $params;
    }

    public function getUserInfoById($userId, $apartment_id) {
        //Tạo query truy vấn
        $query = DB::table('users')
                    ->select('users.id as userId',
                            'users.last_name',
                            'users.first_name',
                            'users.gender',
                            'users.phone',
                            'users.id_card',
                            'users.magnetic_card_code',
                            'users.birthday',
                            'users.married',
                            'users.population',
                            'users.family_register_status',
                            'users.start_at',
                            'users.note',
                            'users.locked',
                            'apartments.id as apartment_id',
                            'blocks.id as block_id',
                            'blocks.name as block_name',
                            'floors.id as floor_id',
                            'floors.name as floor_name',
                            'rooms.id as room_id',
                            'rooms.name as room_name')

                    ->join('rooms', 'rooms.id', '=', 'users.room_id')
                    ->join('floors', 'floors.id', '=', 'rooms.floor_id')
                    ->join('blocks', 'blocks.id', '=', 'floors.block_id')
                    ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')

                    ->whereNull('users.deleted_at')
                    ->whereNull('rooms.deleted_at')
                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')
                    ->whereNull('apartments.deleted_at')

                    ->where('users.id', '=', $userId)
                    ->where('apartments.id', '=', $apartment_id);

        return $query->first();
    }

    public function getListBlockById($apartment_id) {
        //Tạo query truy vấn
        $query = DB::table('blocks')
                    ->select('blocks.id',
                            'blocks.name')

                    ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')

                    ->whereNull('blocks.deleted_at')
                    ->whereNull('apartments.deleted_at')

                    ->where('apartments.id', '=', $apartment_id);
        return $query->orderBy('blocks.name', 'asc')->get();
    }

    public function getListFloorById($apartment_id, $block_id) {
        //Tạo query truy vấn
        $query = DB::table('floors')
                    ->select('floors.id',
                            'floors.name')

                    ->join('blocks', 'blocks.id', '=', 'floors.block_id')
                    ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')

                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')
                    ->whereNull('apartments.deleted_at')

                    ->where('blocks.id', '=', $block_id)
                    ->where('apartments.id', '=', $apartment_id);
        return $query->orderBy('floors.name', 'asc')->get();
    }

    public function getListRoomById($apartment_id, $block_id, $floor_id) {
        //Tạo query truy vấn
        $query = DB::table('rooms')
                    ->select('rooms.id',
                            'rooms.name')

                    ->join('floors', 'floors.id', '=', 'rooms.floor_id')
                    ->join('blocks', 'blocks.id', '=', 'floors.block_id')
                    ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')

                    ->whereNull('rooms.deleted_at')
                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')
                    ->whereNull('apartments.deleted_at')

                    ->where('floors.id', '=', $floor_id)
                    ->where('blocks.id', '=', $block_id)
                    ->where('apartments.id', '=', $apartment_id);
        return $query->orderBy('rooms.name', 'asc')->get();
    }

    public function lock($id) {
        $user = User::findOrFail($id);
        $user->locked = !$user->locked;
    
        $user->save();
        return $user;
    }

    public function remove($id){
        $user = User::findOrFail($id);
        $user->delete();
    }

    function save($params) {
        try {
            DB::beginTransaction();
            
            if(empty($params['id'])) {
                $id = null;
            }
            else {
                $id = $params['id'];
            }
            
            $user = User::firstOrNew([
                'id' => $id,
            ]);
            
            $user->first_name = $params['first_name'];
            $user->last_name = $params['last_name'];
            $user->phone = $params['phone'];
            $user->id_card = $params['id_card'];
            $user->magnetic_card_code = $params['magnetic_card_code'];
            $user->birthday = $params['birthday'];
            $user->population = $params['population'];
            $user->room_id = $params['room'];
            $user->start_at = $params['start_at'];
            $user->note = $params['note'];

            if(!empty($params['gender'])) {
                $user->gender = $params['gender'];
            }

            if(!empty($params['married'])) {
                $user->married = 1;
            } else {
                $user->married = 0;
            }

            if(!empty($params['family_register_status'])) {
                $user->family_register_status = 1;
            } else {
                $user->family_register_status = 0;
            }

            if(!empty($params['locked'])) {
                $user->locked = 1;
            } else {
                $user->locked = 0;
            }
            
            $user->save();
            
            DB::commit();
            return $user;
        } catch(\Exception $ex) {
            \Log::error("App\Actions\Management\AdminResidential - save - " . $ex->getMessage());
            DB::rollBack();
            return null;
        }
    }

    public function getResidentialStatistic($apartment_id) {
        //Tạo query truy vấn
        $query = DB::table('blocks')
                    ->select('blocks.name as blockName',
                            DB::raw('count(rooms.id) as numberOfHousehold'))

                    ->leftJoin('floors', 'floors.block_id', '=', 'blocks.id')
                    ->leftJoin('rooms', 'rooms.floor_id', '=', 'floors.id')

                    ->whereNull('rooms.deleted_at')
                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')

                    ->where('blocks.apartment_id', '=', $apartment_id)
                    ->groupBy('blocks.id');
        return $query->orderBy('blocks.name', 'asc')->get();
    }
}