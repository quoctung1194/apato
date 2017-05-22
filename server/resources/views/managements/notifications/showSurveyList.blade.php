@extends('managements.master')

@section('content')

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
				<td>Update later</td>
				<?php
				if(!empty($notification->remindDate)) {
					$dateTime = strtotime($notification->remindDate);
					$remindDate = date('d-m-Y', $dateTime);
				} else {
					$remindDate = "None";
				}
				?>
				<td>{{ $remindDate }}</td>
				<td>
				<img src="http://tiko.vn/design/standard/images/copy.gif"
					alt="Copy">
					&nbsp; 
				<a href="{{ route('MM-005', ['id' => $survey->id]) }}">
					<img src="http://tiko.vn/design/standard/images/edit.gif" alt="Edit">
				</a>
					&nbsp;
					<img
					src="https://cdn2.iconfinder.com/data/icons/25-free-ui-icons/40/trash_bin-16.png"
					alt="bin, delete, remove, trash, trash bin, trash can icon">&nbsp;
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@endsection