<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')

<!-- Combobox select2 -->
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2-bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/gh-pages.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<script src="{{ URL::asset('resources/select2/select2.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<script src="{{ URL::asset('js/management/apartmentSetting/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="current_route" value="{{URL::route('MAS-001')}}" />
<input type="hidden" id="MAS-003" value="{{URL::route('MAS-003')}}" />
<input type="hidden" id="MAS-004" value="{{URL::route('MAS-004')}}" />
<h1 class="page-header">@lang('main.apartment_setting')</h1>
<div class="table-responsive">
    <form id="editForm" method="POST" action="{{ route('MAS-002') }}" onsubmit="return false">
        {{ csrf_field() }}
        <input type="hidden" id="id" name="id" value="{{ $apartment->id }}" />
        <table style="width: 60%"> 
            <tbody>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.apartment_name')</label>
                        <input type="text" class="form-control" name="apartment_name" value="{{ $apartment->name }}"/>
                        <label name='validate' value='apartment_name_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.address')</label>
                        <input type="text" class="form-control" name="address" value="{{ $apartment->address }}"/>
                        <label name='validate' value='address_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.employer_name')</label>
                        <input type="text" class="form-control" name="employer_name" value="{{ $apartment->employer_name }}"/>
                        <label name='validate' value='employer_name_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.complete_year')</label>
                        <input type="text" id="complete_year" class="form-control" name="complete_year" value="{{ $apartment->complete_year }}"/>
                        <label name='validate' value='complete_year_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.province')</label>
                        <select id="province" class="form-control" name="province" onchange="loadDistrictCombobox()">
                            <option value="-1"></option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}"
                                    <?php
                                    if($province->id == $apartment->province_id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='province_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.district')</label>
                        <select id="district" class="form-control" name="district" onchange="loadWardCombobox()">
                            <option></option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}"
                                    <?php
                                    if($district->id == $apartment->district_id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='district_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.ward')</label>
                        <select id="ward" class="form-control" name="ward">
                            <option></option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}"
                                    <?php
                                    if($ward->id == $apartment->ward_id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $ward->name }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='ward_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">@lang('main.block_number')</label>
                        <table class="table" style="width: 100%;"> 
                            <thead> 
                                <tr>
                                    <th width="10%">@lang('main.no')</th>
                                    <th width="auto%">@lang('main.block')</th>
                                    <th width="10%">@lang('main.floor_number')</th>
                                    <th width="10%">@lang('main.house_over_floor')</th>
                                    <th width="10%">@lang('main.total_household')</th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label" >
                            <input type="checkbox" name="locked" {{ $apartment->locked != 0 ? 'checked' : '' }}/>
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