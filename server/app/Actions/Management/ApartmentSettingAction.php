<?php
namespace App\Actions\Management;

use Illuminate\Support\Facades\DB;
use App\Apartment;

class ApartmentSettingAction {

    public function getListProvince() {
        //Tạo query truy vấn
        $query = DB::table('provinces')
                    ->select('provinces.id',
                            'provinces.name')
                    ->whereNull('provinces.deleted_at');
        return $query->orderBy('provinces.name', 'asc')->get();
    }

    public function getListDistrictById($province_id) {
        if (empty($province_id)) {
            $province_id = -1;
        }

        //Tạo query truy vấn
        $query = DB::table('districts')
                    ->select('districts.id',
                            'districts.name')
                    ->whereNull('districts.deleted_at')
                    ->where('districts.province_id', '=', $province_id);
        return $query->orderBy('districts.name', 'asc')->get();
    }

    public function getListWardById($district_id) {
        if (empty($district_id)) {
            $district_id = -1;
        }

        //Tạo query truy vấn
        $query = DB::table('wards')
                    ->select('wards.id',
                            'wards.name')
                    ->whereNull('wards.deleted_at')
                    ->where('wards.district_id', '=', $district_id);
        return $query->orderBy('wards.name', 'asc')->get();
    }

    public function getApartmentInfoById($apartment_id) {
        //Tạo query truy vấn
        $query = DB::table('apartments')
                    ->select('apartments.id',
                            'apartments.name',
                            'apartments.address',
                            'apartments.employer_name',
                            'apartments.complete_year',
                            'apartments.locked',
                            'wards.id as ward_id',
                            'districts.id as district_id',
                            'provinces.id as province_id')

                    ->join('wards', 'wards.id', '=', 'apartments.ward_id')
                    ->join('districts', 'districts.id', '=', 'wards.district_id')
                    ->join('provinces', 'provinces.id', '=', 'districts.province_id')

                    ->whereNull('apartments.deleted_at')
                    ->whereNull('wards.deleted_at')
                    ->whereNull('districts.deleted_at')
                    ->whereNull('provinces.deleted_at')

                    ->where('apartments.id', '=', $apartment_id);

        return $query->first();
    }

    function save($params) {
        try {
            DB::beginTransaction();
            $apartment = Apartment::firstOrNew([
                'id' => $params['id'],
            ]);
            $apartment->name = $params['apartment_name'];
            $apartment->address = $params['address'];
            $apartment->employer_name = $params['employer_name'];
            $apartment->complete_year = $params['complete_year'];
            $apartment->ward_id = $params['ward'];

            if(!empty($params['locked'])) {
                $apartment->locked = 1;
            } else {
                $apartment->locked = 0;
            }
            
            $apartment->save();
            DB::commit();

            return $apartment;
        } catch(\Exception $ex) {
            \Log::error("App\Actions\Management\ApartmentSetting - save - " . $ex->getMessage());
            DB::rollBack();
            return null;
        }
    }

    public function getStatistic($apartment_id) {
        //Tạo query truy vấn
        $query = DB::table('blocks')
                    ->select('blocks.id as blockId',
                            'blocks.name as blockName',
                            'floors.id as floorId',
                            'floors.name as floorName',
                            'rooms.id as roomId',
                            'rooms.name as roomName')

                    ->leftJoin('floors', 'floors.block_id', '=', 'blocks.id')
                    ->leftJoin('rooms', 'rooms.floor_id', '=', 'floors.id')

                    ->whereNull('rooms.deleted_at')
                    ->whereNull('floors.deleted_at')
                    ->whereNull('blocks.deleted_at')

                    ->where('blocks.apartment_id', '=', $apartment_id);

        $statistics = [];
        $temps = $query->orderBy('blocks.name', 'asc')->get();
        foreach ($temps as $temp) {
            $blockId = $temp->blockId;
            $floorId = $temp->floorId;
            $floorName = $temp->floorName;
            $roomId = $temp->roomId;

            if (empty($floorId)) {
                $floorId = 0;
            } else {
                $floorId = 1;
            }

            if (empty($floorName)) {
                $floorName = 'Không có';
            }

            if (empty($roomId)) {
                $roomId = 0;
            } else {
                $roomId = 1;
            }

            if (isset($statistics[$blockId])) {
                $statistics[$blockId]['floor_number'] += $floorId;
                $statistics[$blockId][$floorName] += $roomId;
            } else {
                $statistics[$block_id] = array(
                    'block' => blockName,
                    'floor_number' => $floorId,
                    $floorName => $roomId,
                );
            }
        }

        return $statistics;
    }
}