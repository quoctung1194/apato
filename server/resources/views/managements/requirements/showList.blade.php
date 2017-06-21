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
<script src="{{ URL::asset('js/management/requirement/showList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="MR-002" value="{{ route('MR-002') }}" />
<input type="hidden" id="MR-004" value="{{ route('MR-004') }}" />
<input type="hidden" id="MR-005" value="{{ route('MR-005') }}" />
<input type="hidden" id="MR-006" value="{{ route('MR-006') }}" />
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}" />

<h1 class="page-header">@lang('main.requirement')</h1>
<div style="margin-bottom: 20px" >
    <a href="{{ route('MR-002') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
</div>
<h2 class="sub-header">@lang('main.requirement_list')</h2>
<div>
	<table id="notificationTable" class="table" style="width: 100%;">
		<thead>
			<tr>
				<th width="10%">#</th>
				<th width="30%">@lang('main.title')</th>
				<th width="10%">@lang('main.type')</th>
				<th width="10%">@lang('main.tag')</th>
				<th width="15%">@lang('main.username')</th>
				<th width="15%">@lang('main.created_at')</th>
				<th width="10%">@lang('main.action')</th>
			</tr>
		</thead>
	</table>
</div>
@endsection
