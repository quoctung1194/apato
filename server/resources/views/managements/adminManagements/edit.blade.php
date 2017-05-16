<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.admin_management')</h1>
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2-bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/gh-pages.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<script src="{{ URL::asset('resources/select2/select2.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('js/management/adminManagement/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<script>
	$(document).ready(function() {
		$("#apartmentId").select2( { placeholder: "@lang('main.select_apartment')" } );
	});
</script>

<input type="hidden" id="current_route" value="{{URL::route('MA-001')}}" />

<div class="table-responsive">
	<form id="editForm" method="POST" action="{{ route('MA-002') }}" onsubmit="return false">
		{{ csrf_field() }}
		<table style="width: 60%">
			<tbody>
				<tr>
					<td colspan="2">
						<label class="control-label">@lang('main.apartment')</label>
						<select id="apartmentId" name="apartment_id" class="form-control">
							<option></option>
							@foreach($apartments as $apartment)
							<option value='{{$apartment->id}}' 
								<?php if ($admin->is_super_admin=='0') { echo 'selected="selected"'; } ?>>
								{{ $apartment->name }}
							</option>
							@endforeach
						</select>
						<label name='validate' value='apartment_id_error' style="color: red">
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<label class="control-label">@lang('main.last_name')</label>
						<input type="text" class="form-control" name="last_name" 
							value="<?php if ($admin->is_super_admin=='0') { echo $admin->last_name; } ?>">
						<label name='validate' value='last_name_error' style="color: red">
						</label>
					</td>
					<td style="padding-left: 10px">
						<label class="control-label">@lang('main.first_name')</label>
						<input type="text" class="form-control" name="first_name"
							value="<?php if ($admin->is_super_admin=='0') { echo $admin->first_name; } ?>">
						<label name='validate' value='first_name_error' style="color: red">
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<label class="control-label">@lang('main.nickname')</label>
						<input type="text" class="form-control" name="username"
							value="<?php if ($admin->is_super_admin=='0') { echo $admin->username; } else {echo '';} ?>" 
							<?php if ($admin->is_super_admin=='0') { echo 'readonly="readonly"'; } ?>>
						<label name='validate' value='username_error' style="color: red">
						</label>
					</td>
				</tr>
				<tr>
					<td>
						@if($admin->is_super_admin == '0')
						<a href="{{ route('MA-003') }}">@lang('main.change_password_1')</a>
						@else
						<label class="control-label">@lang('main.password_1')</label>
						<input type="password" class="form-control" name="password1">
						<label name='validate' value='password1_error' style="color: red"></label><br/>
						
						<label class="control-label">@lang('main.confirm_password_1')</label>
						<input type="password" class="form-control" name="confirm_password1">
						<label name='validate' value='confirm_password1_error' style="color: red"></label>
						@endif
					</td>
					<td style="padding-left: 10px">
						@if($admin->is_super_admin == '0')
						<a href="{{ route('MA-005') }}">@lang('main.change_password_2')</a>
						@else
						<label class="control-label">@lang('main.password_2')</label>
						<input type="password" class="form-control" name="password2">
						<label name='validate' value='password2_error' style="color: red"></label><br/>
						
						<label class="control-label">@lang('main.confirm_password_2')</label>
						<input type="password" class="form-control" name="confirm_password2">
						<label name='validate' value='confirm_password2_error' style="color: red"></label>
						@endif
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