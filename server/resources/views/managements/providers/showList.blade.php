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
<script src="{{ URL::asset('js/management/provider/showList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="MSEP-002" value="{{ route('MSEP-002') }}" />
<input type="hidden" id="MSEP-003" value="{{ route('MSEP-003') }}" />
<input type="hidden" id="MSEP-004" value="{{ route('MSEP-004') }}" />
<input type="hidden" id="MSEP-005" value="{{ route('MSEP-005') }}" />
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}" />

<h1 class="page-header">Nhà cung cấp</h1>
<div style="margin-bottom: 20px">
	<a href="{{ route('MSEP-003') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
</div>
<div>
	<table id="providers" class="table" style="width: 100%;">
		<thead>
			<tr>
				<th width="10%">@lang('main.no')</th>
				<th width="auto">@lang('main.provider_name')</th>
				<th width="20%">@lang('main.option')</th>
			</tr>
		</thead>
	</table>
</div>
@endsection
