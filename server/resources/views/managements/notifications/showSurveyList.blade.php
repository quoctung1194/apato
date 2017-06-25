<?php 
use App\Constants\CommonConstant;
?>
@extends('managements.master')

@section('content')
<script src="{{ URL::asset('js/management/notification/showList.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" value="{{ route('MM-007') }}" id="MM-007" />

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
<div class="table-responsive">
	<table id="notificationTable" class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>@lang('main.survey_title')</th>
				<th>@lang('main.created_at')</th>
				<th>@lang('main.created_by')</th>
				<th>@lang('main.remind_date')</th>
				<th>@lang('main.action')</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($surveys as $survey)
			<tr>
				<td>{{ $survey->id }}</td>
				<td>{{ $survey->title }}</td>
				<td>{{ $survey->created_at->format('d-m-Y') }}</td>
				<td>{{ $survey->createdBy->username }}</td>
				<td>
					<?php
						if(!empty($survey->remindDate)) {
							$dateTime = strtotime($survey->remindDate);
							$remindDate = date('d-m-Y', $dateTime);
						} else {
							$remindDate = "None";
						}
					?>
					{{ $remindDate }}
				</td>
				<td>
					<a href="{{ route('MM-005', ['id' => $survey->id]) }}">
                        <i class="fa fa-pencil" aria-hidden="true" title="Edit"></i>
                    </a>
                    &nbsp;&nbsp;
                    <a style="cursor:pointer" onclick="remove('{{ $survey->id }}', this)">
                        <i class="fa fa-trash" aria-hidden="true" title="Remove"></i>
                    </a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection