<?php 
use App\Constants\CommonConstant;
?>
@extends('managements.master')

@section('content')

<!-- Combobox select2 -->
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/select2-bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<link rel="stylesheet" href="{{ URL::asset('resources/select2/gh-pages.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
<script src="{{ URL::asset('resources/select2/select2.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<!-- Datatable -->
<script src="{{ URL::asset('resources/datatables/jquery.dataTables.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('resources/datatables/dataTables.bootstrap.min.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<link rel="stylesheet" href="{{ URL::asset('resources/datatables/dataTables.bootstrap.css?v=' . CommonConstant::RESOURCE_VERSION) }}">

<script src="{{ URL::asset('js/management/service/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<style>
	.tag {
		background-color: #666666;
		padding: 6 10 6 10;
		border-radius: 5px;
		color: white;
		font-size: 14px;
		margin-bottom: 10;
		margin-right: 5;
	}
</style>

@if(!empty($service->id))
<input type="hidden" name="MSE-006" id="MSE-006" value="{{ route('MSE-006') . '?serviceId=' . $service->id }}" />
@endif
<input type="hidden" name="MPST-001" id="MPST-001" value="{{ route('MPST-001') }}" />
<input type="hidden" id="current_route" value="{{URL::route('MSE-003')}}" />

<h1 class="page-header">@lang('main.detail_service')</h1>
	<form id="editForm" method="POST" action="{{ route('MSE-007') }}" onsubmit="return false">
		{{ csrf_field() }}
		<input type="hidden" name="id" id="id" value="{{ $service->id }}" />
		<input type="hidden" name="apartmentIds" id="apartmentIds" />
		
		<table class="table"> 
			<tbody> 
				<tr>
					<td style="width: 50%; border-top: 0">
						<label class="control-label">@lang('main.service_type')</label>
						<select id="service_type" class="form-control"
							onchange="loadProviderCombobox()" name="service_type">
							<option></option>
							@foreach($serviceTypes as $serviceType)
								<option value="{{ $serviceType->id }}"
									<?php
									if($service->selectedServiceType == $serviceType->id) {
										echo 'selected';
									}
									?>
								>
									{{ $serviceType->name }}
								</option>
							@endforeach
						</select>
						<label name='validate' value='service_type_error' style="color: red"></label>
						<br />
						
						<label class="control-label">@lang('main.service_name')</label>
						<br />
						<input type="text" class="form-control" name="name" value="{{ $service->name }}">
						<label name='validate' value='name_error' style="color: red"></label>
						<br />
						
						<img src="{{ URL::asset($service->image) }}" class="img-rounded" height="150" style="object-fit: contain;
							<?php
								if(empty($service->id)) {
									echo "display: none";
								}
							?>"
						/>
						<input class="form-control" type="file"
							id="fileInput" name="image" style="margin-top: 8px">
						<label name='validate' value='image_error' style="color: red"></label>
						<br />
						
						<label class="control-label">@lang('main.link_url')</label>
						<br />
						<input class="form-control" type="text" name="url" value="{{ $service->url }}">
						<label name='validate' value='url_error' style="color: red"></label>
						<br />
						
						<label class="control-label">@lang('main.content')</label>
						<textarea class="form-control" rows="6" id="content" name="content">{{ $service->content }}</textarea>
						<label name='validate' value='content_error' style="color: red"></label>
						<br />
						
						<button class="btn btn-default" onclick="submitForm()">@lang('main.complete')</button>
					</td>
					<td style="border-top: 0">
						<div style="margin-bottom: 22px">
							<label class="control-label">@lang('main.apartment_list')</label>
							<!-- Danh sách chung cư -->
							<div id="apartmentTags">
							@if(!empty($service->id))
								@foreach($selectedApartments as $apartment)
									<div class="tag btn">{{ $apartment->name }}</div>
								@endforeach
							@endif
							</div>
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#apartmentModel">
								@lang('main.add_apartment')
							</button>
							<br />
							<label name='validate' value='apartmentIds_error' style="color: red"></label>
						</div>
						
						<label class="control-label">@lang('main.provider')</label>
						<select id="provider" name="provider"
							class="form-control" {{ empty($service->id) ? 'disabled="disabled"' : '' }}>
							<option></option>
							@if(!empty($service->id))
								@foreach($providers as $provider)
								<option value="{{ $provider->id }}"
									<?php
									if($service->selectedProvider == $provider->id) {
										echo 'selected';
									}
									?>
								>
									{{ $provider->name }}
								</option>
								@endforeach
							@endif
						</select>
						<label name='validate' value='provider_error' style="color: red"></label>
						<br />
						
						<label class="control-label">@lang('main.service_start_at')</label>
						<input type="text" id="start_at" name="start_at" class="form-control" value="{{ $service->start_at }}" />
						<label name='validate' value='start_at_error' style="color: red"></label>
						<br />
						
						<label class="control-label">@lang('main.service_end_at')</label>
						<input type="text" id="end_at" name="end_at" class="form-control" value="{{ $service->end_at }}" />
						<label name='validate' value='end_at_error' style="color: red"></label>
						<br />
						
						<label class="control-label">@lang('main.phone')</label>
						<input class="form-control" type="text" name="phone" value="{{ $service->phone }}">
						<label name='validate' value='phone_error' style="color: red"></label>
						<br />
						
						<label class="control-label" style="margin-top: 10px">
							<input type="checkbox" name="locked" {{ $service->locked != 0 ? 'checked' : '' }} />
							@lang('main.lock')
						</label>
						<br />
						
						<label class="control-label" style="margin-top: 10px">
							<input type="checkbox" name="re_call" {{ $service->re_call != 0 ? 'checked' : '' }} />
							@lang('main.user_request_recall_available')
						</label>
						<br />
					</td>
				</tr>
			</tbody>
		</table>
		
		<!-- Danh sách click -->
		@if(!empty($service->id))
			<label style="margin-bottom: 20px">@lang('main.click_number', ['total_click' => $service->totalClick])
			<?php
				$now = new DateTime();
				echo $now->format('d-m-Y');
			?>
			</label>
			<table class="table" id="clicks">
				<thead>
					<tr>
						<th width="5%">@lang('main.no')</th>
						<th width="10%">@lang('main.last_name')</th>
						<th width="10%">@lang('main.first_name')</th>
						<th width="15%">@lang('main.apartment')</th>
						<th width="8%">@lang('main.block')</th>
						<th width="8%">@lang('main.floor')</th>
						<th width="8%">@lang('main.room')</th>
						<th width="8%">@lang('main.clicks')</th>
<!-- 						<th width="8%">Yêu cầu gọi lại</th> -->
<!-- 						<th width="auto">Ghi chú thông tin</th> -->
					</tr>
				</thead>
			</table>
		@endif
	</form>
@endsection

<!-- Modal -->
<div id="apartmentModel" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">@lang('main.apartment_list')</h4>
			</div>
			<div class="modal-body">
				<table id="apartments" class="table" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%"></th>
							<th width="auto">@lang('main.apartment_name')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($apartments as $apartment)
							<tr>
								<td>
									<input type='checkbox' value='{{ $apartment->id }}' name="{{ $apartment->name }}" 
									<?php 
									if(!empty($service->id)) {
										foreach($selectedApartments as $selectedApartment) {
											if($selectedApartment->id == $apartment->id) {
												echo 'checked';
												break;
											}
										}
									}
									?>
									/>
								</td>
								<td>
									{{ $apartment->name }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onClick="getSelectedApartments()">@lang('main.save')</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('main.close')</button>
			</div>
		</div>

	</div>
</div>