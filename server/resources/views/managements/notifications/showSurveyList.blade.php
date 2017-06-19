<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('resources/datatables/dataTables.bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/fontAwesome/css/font-awesome.css?v=' . CommonConstant::RESOURCE_VERSION) }}">

<script src="{{ URL::asset('resources/datatables/jquery.dataTables.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('resources/datatables/dataTables.bootstrap.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('js/management/notification/showSurveyList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="MM-005" value="{{ route('MM-005') }}" />
<input type="hidden" id="MM-007" value="{{ route('MM-007') }}" />
<input type="hidden" id="MM-008" value="{{ route('MM-008') }}" />
<input type="hidden" id="MM-009" value="{{ route('MM-009') }}" />
<input type="hidden" id="csrf-token" value="{{ csrf_token() }}" />

<h1 class="page-header">@lang('main.opinion_survey')</h1>
<div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="{{ route('MM-005') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder"></div>
    <div class="col-xs-6 col-sm-3 placeholder"></div>
    <div class="col-xs-6 col-sm-3 placeholder"></div>
</div>
<h2 class="sub-header">@lang('main.survey_list')</h2>
<div>
    <table id="notificationTable" class="table" style="width: 100%;">
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="auto%">@lang('main.survey_title')</th>
                <th width="10%">@lang('main.created_at')</th>
                <th width="10%">@lang('main.created_by')</th>
                <th width="10%">@lang('main.remind_date')</th>
                <th width="10%">@lang('main.action')</th>
            </tr>
        </thead>
    </table>
</div>
@endsection