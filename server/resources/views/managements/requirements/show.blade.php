@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.requirement')</h1>

<div class="table-responsive">
	<table class="table"> 
		<tbody> 
			<tr> 
				<td style="width: 60%">
					<label class="control-label">@lang('main.title'): </label>
					<label class="control-label">{{$requirement->title}}</label><br/>
					
					<label class="control-label">@lang('main.created_at'): </label>
					<label>{{$requirement->created_at}}</label><br/>
					
					<label class="control-label">@lang('main.type'): </label>
					<label>{{$requirement->typeContent}}</label><br/>
					
					<label class="control-label">@lang('main.tag'): </label>
					<label>{{$requirement->tagContent}}</label><br/>
					
					<label class="control-label">@lang('main.repeat_problem'): </label>
					<?php
						$repeat = 'Không';
						if($requirement->is_repeat_problem) {
							$repeat = 'Có';
						}
					?>
					<label>{{$repeat}}</label><br/>
					
					<label class="control-label">@lang('main.content')</label>
					<textarea class="form-control" rows="3" rows="33" name="subTitle" readonly="readonly">{{$requirement->description}}</textarea><br/>
					
					@foreach($requirement->requirementImages as $image)
					<a target="_blank" href="{{ URL::asset($image->path) }}">
						<img src="{{ URL::asset($image->path) }}"
							class="img-rounded" style="object-fit: contain" alt="Cinque Terre" width=80 height="80">
					</a>
					@endforeach
				</td>
				<td>
					
				</td>
			</tr>
		</tbody>
	</table>
	<br/>
</div>
@endsection