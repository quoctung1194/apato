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
<script src="{{ URL::asset('js/management/service/showList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="MSE-002" value="{{ route('MSE-002') }}" />
<input type="hidden" id="MSE-003" value="{{ route('MSE-003') }}" />
<input type="hidden" id="MSE-004" value="{{ route('MSE-004') }}" />
<input type="hidden" id="MSE-005" value="{{ route('MSE-005') }}" />
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}" />

<h1 class="page-header">@lang('main.service')</h1>
<div style="margin-bottom: 20px">
	<a href="{{ route('MSE-003') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
</div>
<div>
	<table id="services" class="table" style="width: 100%;">
		<thead>
			<tr>
				<th width="10%">@lang('main.no')</th>
				<th width="auto">@lang('main.service_name')</th>
				<th width="20%">@lang('main.provider_name')</th>
				<th width="20%">@lang('main.service_type_name')</th>
				<th width="10%">@lang('main.option')</th>
			</tr>
		</thead>
	</table>
</div>
@endsection
