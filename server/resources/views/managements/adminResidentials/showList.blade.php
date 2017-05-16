<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<!-- <link rel="stylesheet" href="{{ URL::asset('resources/dataTables/jquery.dataTables.min.css?v=' . CommonConstant::RESOURCE_VERSION) }}"> -->
<link rel="stylesheet" href="{{ URL::asset('resources/datatables/dataTables.bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/fontAwesome/css/font-awesome.css?v=' . CommonConstant::RESOURCE_VERSION) }}">

<script src="{{ URL::asset('resources/datatables/jquery.dataTables.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('resources/datatables/dataTables.bootstrap.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('js/management/adminResidential/showList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="MAR-002" value="{{ route('MAR-002') }}" />
<input type="hidden" id="MAR-003" value="{{ route('MAR-003') }}" />
<input type="hidden" id="MAR-004" value="{{ route('MAR-004') }}" />
<input type="hidden" id="MAR-005" value="{{ route('MAR-005') }}" />
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}" />

<h1 class="page-header">@lang('main.admin_residential')</h1>
<div style="margin-bottom: 20px" >
    <a href="{{ route('MAR-003') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
</div>
<div>
    <table id="residentials" class="table" style="width: 100%;"> 
        <thead> 
            <tr>
                <th width="10%">@lang('main.no')</th>
                <th width="10%">@lang('main.last_name')</th>
                <th width="auto%">@lang('main.first_name')</th>
                <th width="10%">@lang('main.block')</th>
                <th width="10%">@lang('main.floor')</th>
                <th width="10%">@lang('main.room')</th>
                <th width="20%">@lang('main.option')</th>
            </tr>
        </thead>
    </table>
</div>
@endsection