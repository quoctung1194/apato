<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.provider')</h1>
<link rel="stylesheet" href="{{ URL::asset('resources/datatables/dataTables.bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">

<script src="{{ URL::asset('resources/datatables/jquery.dataTables.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('resources/datatables/dataTables.bootstrap.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('js/management/provider/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="current_route" value="{{URL::route('MSEP-003')}}" />

<div class="table-responsive">
	<form id="editForm" method="POST" action="{{ route('MSEP-006') }}" onsubmit="return false">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $provider->id }}" />
		<input type="hidden" name='services' id='services' value='' />
		
		<table style="width: 60%">
			<tbody>
				<tr>
					<td>
						<label class="control-label">@lang('main.provider_name')</label>
						<input type="text" class="form-control" name="name" value="{{ $provider->name }}" />
						<label name='validate' value='name_error' style="color: red"></label>
					</td>
				</tr>
				<tr>
					<td>
						<label class="control-label">@lang('main.service_type')</label><br/>
						<label name='validate' value='services_error' style="color: red"></label>
						
						<table id="serviceTypes" class="table" style="width: 100%;">
							<thead>
								<tr>
									<th width="10%"></th>
									<th width="auto">@lang('main.type_name')</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($serviceTypes as $type)
								<tr>
									<td>
										<input type="checkbox" value="{{ $type->id }}"
											<?php
												foreach($typesOfProvider as $providerType) {
													if($providerType->id == $type->id) {
														echo 'checked';
													}
												}
											?>
											 />
									</td>
									<td>{{ $type->name }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						
					</td>
				</tr>
				<tr>
					<td>
						</br>
						<input type="checkbox" name="locked" {{ $provider->locked != 0 ? 'checked' : '' }}/>
						<label class="control-label">@lang('main.lock')</label><br/>
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