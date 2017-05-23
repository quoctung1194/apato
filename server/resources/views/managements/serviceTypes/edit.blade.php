<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')

<script src="{{ URL::asset('js/management/serviceType/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="current_route" value="{{ URL::route('MSET-003') }}" />

<h1 class="page-header">@lang('main.service_type')</h1>

<div class="table-responsive">
	<form id="editForm" method="POST" action="{{ route('MSET-006') }}" onsubmit="return false">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $serviceType->id }}" />
		
		<table style="width: 60%"> 
			<tbody>
				<tr>
					<td>
						<label class="control-label">@lang('main.service_type_name')</label>
						<input type="text" class="form-control" name="name" value="{{ $serviceType->name }}">
						<label name='validate' value='name_error' style="color: red"></label>
					</td>
				</tr>
				<tr> 
					<td>
						<img src="{{ URL::asset($serviceType->image) }}" class="img-rounded" height="150"
							id="image" style="object-fit: contain;
							<?php
								if(empty($serviceType->id)) {
									echo "display: none";
								}
							?>"
						/>
						<input class="form-control" type="file"
							style="margin-top: 8px" id="fileInput" name="image">
						<label name='validate' value='image_error' style="color: red"></label>
					</td>
				</tr>
				<tr> 
					<td>
						<input type="checkbox" name="locked" {{ $serviceType->locked != 0 ? 'checked' : '' }} />
						<label class="control-label">@lang('main.lock')</label>
					</td>
				</tr>	
				<tr> 
					<td>
						<button class="btn btn-default" onclick="submitForm()">@lang('main.complete')</button>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
@endsection