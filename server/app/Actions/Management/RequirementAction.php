<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Apartment;
use App\Setting;
use App\User;
use App\Requirement;

class RequirementAction {	
    
     public function showList($apartmentId) {
         try {
             
            $requirements = DB::table('requirements')
            ->join('users', 'users.id', '=', 'requirements.user_id')
            ->join('rooms', 'rooms.id', '=', 'users.room_id')
            ->join('floors', 'floors.id', '=', 'rooms.floor_id')
            ->join('blocks', 'blocks.id', '=', 'floors.block_id')
            ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')
            ->select('requirements.*')
            ->where('apartments.id', '=', $apartmentId)
            ->orderBy('requirements.id', 'desc')
            ->get();
            
            //Get Setting
            $setting = Setting::where([
                ['apartment_id', '=', $apartmentId],
            ])->first();
                
            $types = $setting->getTypes();
            $tags = $setting->getTags();
                
            foreach($requirements as $requirement) {
                $tag = $this->getTagById($requirement->tag_id, $tags);
                $type = $this->getTypeById($requirement->type_id, $types);
                $account = User::findOrFail($requirement->user_id);
                
                $requirement->tagContent = $tag->content;
                $requirement->typeContent = $type->content;
                $requirement->account = $account->username;
            }
            
            return $requirements;
         } catch(\Exception $ex) {
             Log::error("App\Actions\Management\RequirementAction - showList - " . $ex->getMessage());
            return array();
        }
    }
    
    function getTagById($requirementId, $tags) {
        foreach($tags as $tag) {
            if($tag->id == $requirementId) {
                return $tag;
            }
        }
        
        return null;
    }
    
    function getTypeById($requirementId, $types) {
        foreach($types as $type) {
            if($type->id == $requirementId) {
                return $type;
            }
        }
        
        return null;
    }
    
    function getRequirement($id) {
        try {
            $requirement = Requirement::findOrFail($id);

            //Get Setting
            $admin = auth()->guard('admin')->user();
            $setting = Setting::where([
                    ['apartment_id', '=', $admin->apartment_id],
            ])->first();
                
            $types = $setting->getTypes();
            $tags = $setting->getTags();
            
            $tag = $this->getTagById($requirement->tag_id, $tags);
            $type = $this->getTypeById($requirement->type_id, $types);
            
            return $requirement;
        } catch(\Exception $ex) {
            Log::error("App\Actions\Management\RequirementAction - getRequirement - " . $ex->getMessage());
            return array();
        }
    }

    public function getJsonList($params) {
        $apartmentId = $params['apartmentId'];

        //Khai báo mới dữ trả về
        $params['data'] = array();

        //Mảng của các thuộc tính(column) để hiển thị trên giao diện
        $columns = array(
                'none',
                'title',
                'type_id',
                'tag_id',
                'user_id',
                'created_at',
                'none',
        );

        //Lấy ra vị trí được sort
        $sortedIndex = $params['order']['column'];

        //Tạo query truy vấn
        $query = DB::table('requirements')
                    ->select('requirements.id',
                            'requirements.title',
                            'requirements.type_id',
                            'requirements.tag_id',
                            'requirements.user_id',
                            'requirements.locked',
                            'requirements.created_at')
                    ->join('users', 'users.id', '=', 'requirements.user_id')
                    ->join('rooms', 'rooms.id', '=', 'users.room_id')
                    ->join('floors', 'floors.id', '=', 'rooms.floor_id')
                    ->join('blocks', 'blocks.id', '=', 'floors.block_id')
                    ->join('apartments', 'apartments.id', '=', 'blocks.apartment_id')
                    ->whereNull('users.deleted_at')
                    ->whereNull('rooms.deleted_at')
                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')
                    ->whereNull('apartments.deleted_at')
                    ->where('apartments.id', '=', $apartmentId);

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

        //Get Setting
        $setting = Setting::where([
            ['apartment_id', '=', $apartmentId],
        ])->first();
            
        $types = $setting->getTypes();
        $tags = $setting->getTags();
        
        $requirements = $params['data'];
        foreach($requirements as $requirement) {
            $tag = $this->getTagById($requirement->tag_id, $tags);
            $type = $this->getTypeById($requirement->type_id, $types);
            $account = User::findOrFail($requirement->user_id);
            
            $requirement->tagContent = $tag->content;
            $requirement->typeContent = $type->content;
            $requirement->account = $account->username;
        }

        return $params;
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
            
            $requirement = Requirement::firstOrNew([
                'id' => $id,
            ]);
            $requirement->title = $params['title'];
            $requirement->created_at = $params['created_at'];
            $requirement->type_id = $params['type'];
            $requirement->tag_id = $params['tag'];
            $requirement->is_repeat_problem = $params['is_repeat_problem'];
            $requirement->description = $params['description'];
            $requirement->user_id = $params['user_id'];

            if(!empty($params['locked'])) {
                $requirement->locked = 1;
            } else {
                $requirement->locked = 0;
            }
            
            $requirement->save();
            
            DB::commit();
            return $requirement;
        } catch(\Exception $ex) {
            Log::error("App\Actions\Management\RequirementAction - save - " . $ex->getMessage());
            DB::rollBack();
            return null;
        }
    }

    public function lock($id) {
        $requirement = Requirement::findOrFail($id);
        $requirement->locked = !$requirement->locked;
    
        $requirement->save();
        return $requirement;
    }

    public function remove($id){
        $requirement = Requirement::findOrFail($id);
        $requirement->delete();
    }
}