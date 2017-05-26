<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<!-- Combobox date -->
<script src="{{ URL::asset('js/moment.js') }}"></script>
<script src="{{ URL::asset('js/combodate.js') }}"></script>

<!-- Combobox select2 -->
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2-bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/gh-pages.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<script src="{{ URL::asset('resources/select2/select2.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<script src="{{ URL::asset('js/management/adminResidential/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="current_route" value="{{URL::route('MAR-003')}}" />
<input type="hidden" id="MAR-007" value="{{URL::route('MAR-007')}}" />
<input type="hidden" id="MAR-008" value="{{URL::route('MAR-008')}}" />
<h1 class="page-header">@lang('main.admin_residential')</h1>
<div class="table-responsive">
    <form id="editForm" method="POST" action="{{ route('MAR-006') }}" onsubmit="return false">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $user->userId }}" />
        <input type="hidden" id="apartment_id" name="apartment_id" value="{{ $apartmentId }}" />
        <table style="width: 60%"> 
            <tbody>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.last_name')</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $user->last_name }}"/>
                        <label name='validate' value='last_name_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.first_name')</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $user->first_name }}"/>
                        <label name='validate' value='first_name_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <select id="gender" class="form-control" name="gender" value="">
                            <?php
                            $listGender = array(
                                '1' => 'Bà',
                                '2' => 'Ông',
                            );
                            ?>
                            <option></option>
                            @foreach($listGender as $key => $value)
                                <option value="{{ $key }}"
                                    <?php
                                    if($key == $user->gender) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='gender_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.phone')</label>
                        <input type="text" id="phone" class="form-control" name="phone" value="{{ $user->phone }}"/>
                        <label name='validate' value='phone_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.id_card')</label>
                        <input type="text" id="id_card" class="form-control" name="id_card" value="{{ $user->id_card }}"/>
                        <label name='validate' value='id_card_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.magnetic_card_code')</label>
                        <input type="text" id="magnetic_card_code" class="form-control" name="magnetic_card_code" value="{{ $user->magnetic_card_code }}"/>
                        <label name='validate' value='magnetic_card_code_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.birthday')</label>
                        <input type="text" id="birthday" class="form-control" name="birthday" value="{{ $user->birthday }}"/>
                        <label name='validate' value='birthday_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">
                            <input type="checkbox" id="married" name="married" />
                            @lang('main.married')
                        </label>
                    </td>
                    <td style="padding-left: 10px">
                        <label class="control-label">@lang('main.population')</label>
                        <input type="text" id="population" class="form-control" name="population" value="{{ $user->population }}"/>
                        <label name='validate' value='population_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">
                            <input type="checkbox" id="married" name="family_register_status" {{ $user->married != 0 ? 'checked' : '' }} />
                            @lang('main.family_register_status')
                        </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <select id="block" class="form-control" name="block" 
                            <?php
                                if(empty($user->id)) {
                                    echo "onchange=\"loadFloorCombobox()\"";
                                }
                            ?>
                        >
                            <option></option>
                            @foreach($blocks as $block)
                                <option value="{{ $block->id }}"
                                    <?php
                                    if($user->block_id == $block->id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $block->name }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='block_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <label class="control-label">@lang('main.floor')</label>
                        <select id="floor" class="form-control" onchange="loadRoomCombobox()" name="floor" >
                            <option></option>
                            @foreach($floors as $floor)
                                <option value="{{ $floor->id }}"
                                    <?php
                                    if($user->floor_id == $floor->id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $floor->name }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='floor_error' style="color: red"></label>
                    </td>
                    <td width="50%" style="padding-left: 10px">
                        <label class="control-label">@lang('main.room')</label>
                        <select id="room" class="form-control" name="room" >
                            <option></option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}"
                                    <?php
                                    if($user->room_id == $room->id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='room_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label name='validate' class="control-label">@lang('main.residential_start_at')</label>
                    </td>
                    <td style="padding-left: 10px">
                        <input type="text" id="start_at" data-format="YYYY-MM-DD" data-template="D MMM YYYY" name="start_at" value="{{ empty($user->start_at) ? date("Y-m-d") : $user->start_at }}"/>
                        <label name='validate' value='start_at_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.note')</label>
                        <textarea class="form-control" rows="6" id="note" name="note">{{ $user->note }}</textarea>
                        <label name='validate' value='note_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label" >
                            <input type="checkbox" name="locked" {{ $user->locked != 0 ? 'checked' : '' }}/>
                            @lang('main.lock')
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px">
                        <button class="btn btn-default" onclick="submitForm()">@lang('main.complete')</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection