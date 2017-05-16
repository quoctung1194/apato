@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.requirement')</h1>
<div class="row placeholders">
	<div class="col-xs-6 col-sm-3 placeholder">
		
	</div>
	<div class="col-xs-6 col-sm-3 placeholder"></div>
	<div class="col-xs-6 col-sm-3 placeholder"></div>
	<div class="col-xs-6 col-sm-3 placeholder"></div>
</div>
<h2 class="sub-header">@lang('main.requirement_list')</h2>
<div class="table-responsive">
	<table id="notificationTable" class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>@lang('main.title')</th>
				<th>@lang('main.type')</th>
				<th>@lang('main.tag')</th>
				<th>@lang('main.username')</th>
				<th>@lang('main.created_at')</th>
				<th>@lang('main.action')</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($requirements as $requirement)
			<tr>
				<td>{{ $requirement->id }}</td>
				<td>{{ $requirement->title }}</td>
				<td>{{ $requirement->typeContent }}</td>
				<td>{{ $requirement->tagContent }}</td>
				<td>{{ $requirement->account }}</td>
				<td>{{ $requirement->created_at }}</td>
				<td>
					<img src="http://tiko.vn/design/standard/images/copy.gif"
						alt="Copy">&nbsp;
					<a href="{{ route('MR-002', ['id' => $requirement->id]) }}">
						<img src="http://tiko.vn/design/standard/images/edit.gif" alt="Edit">&nbsp;
					</a>
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
