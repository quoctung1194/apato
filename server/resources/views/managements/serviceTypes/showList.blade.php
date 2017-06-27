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
<script src="{{ URL::asset('js/management/serviceType/showList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="MSET-002" value="{{ route('MSET-002') }}" />
<input type="hidden" id="MSET-003" value="{{ route('MSET-003') }}" />
<input type="hidden" id="MSET-004" value="{{ route('MSET-004') }}" />
<input type="hidden" id="MSET-005" value="{{ route('MSET-005') }}" />
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}" />

<h1 class="page-header">@lang('main.service_type')</h1>
<div style="margin-bottom: 20px">
	<a href="{{ route('MSET-003') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
</div>
<div>
	<table id="types" class="table" style="width: 100%;">
		<thead>
			<tr>
				<th width="10%">@lang('main.no')</th>
				<th width="auto">@lang('main.type_name')</th>
				<th width="10%">@lang('main.service_type_order')</th>
				<th width="20%">@lang('main.option')</th>
				<th width="0%"></th>
			</tr>
		</thead>
	</table>
</div>
@endsection
