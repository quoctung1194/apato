<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.change_password_1')</h1>
<script src="{{ URL::asset('js/management/adminManagement/editPassword.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="current_route" value="{{URL::route('MA-003')}}" />

<div class="table-responsive">
	<form id="editForm" method="POST" action="{{ route('MA-004') }}" onsubmit="return false">
		{{ method_field('PUT') }}
		{{ csrf_field() }}
		<table style="width: 60%">
			<tbody>
				<tr>
					<td>
						<label class="control-label">@lang('main.old_password')</label>
						<input type="password" class="form-control" name="old_password" />
						<label name='validate' value='old_password_error' style="color: red"></label>
					</td>
				</tr>
				<tr>
					<td>
						<label class="control-label">@lang('main.new_password')</label>
						<input type="password" class="form-control" name="new_password" />
						<label name='validate' value='new_password_error' style="color: red"></label>
					</td>
				</tr>
				<tr>
					<td>
						<label class="control-label">@lang('main.reenter_new_password')</label>
						<input type="password" class="form-control" name="confirm_password" />
						<label name='validate' value='confirm_password_error' style="color: red"></label>
					</td>
				</tr>
				<tr>
					<td>
						<button onclick="submitForm()" class="btn btn-default">@lang('main.complete')</button>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
@endsection