@extends('managements.master')

<?php
use App\Notification;
use App\Actions\Management\SurveyAction;
?>
@section('content')
<h1 class="page-header">@lang('main.survey')</h1>
<script src="{{ URL::asset('resources/ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('js/management/notification/edit.js') }}"></script>
<script src="{{ URL::asset('js/management/notification/editSurvey.js') }}"></script>

<link rel="stylesheet" href="{{ URL::asset('resources/fontAwesome/css/font-awesome.min.css') }}">

<div class="table-responsive">
	<form method="POST" action="{{ route('MM-006') }}" id="Optionsform">
	{!! Form::model($notification , [
		'route' => ['MM-006', $notification->id],
		'method' => 'post',
		'id' => 'Optionsform']) !!}
		{!! Form::hidden('id', null) !!}
		<table class="table"> 
			<tbody> 
				<tr> 
					<td style="width: 60%">
						<label class="control-label">@lang('main.survey_title')</label>
						 {!! Form::text('title', null, ['class' => 'form-control']) !!}<br/>
						
						<label class="control-label">@lang('main.short_description')</label>
						{!! Form::textarea('subTitle', null, ['class' => 'form-control', 'rows' => 3]) !!}<br/>
						
						<label class="control-label">@lang('main.content')</label>
						{!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 3]) !!}<br/>
						<br />
						
						<?php if(!$notification->id) { ?>
						<select class="form-control" style="width: 200px;" id="typeCheck" name="typeCheck">
							<option value="<?php echo Notification::CHECK_MULTIPLE ?>">Multi Choice</option>
							<option value="<?php echo Notification::CHECK_SINGLE ?>">Single Choice</option>
						</select>
						<br/>
						
						<table id="option">
							<tr>
								<td style="padding-right: 5px">
									<button type="button" onclick="addRow();">
										<i class="fa fa-plus" aria-hidden="true"></i>
									</button>
								</td>
								<td>
									<input type="text" id="optionContent" class="form-control" style="width: 200px" value="" placeholder="@lang('main.enter_content')" />
								</td>
							</tr>
						</table>
						
						<div id="otherContainer" onclick="addOther();">
							<button type="button" class="btn btn-link">
								@lang('main.other_opinion')
							</button>
						</div>
						<input type="hidden" name="options" id="options" />
						<br/>
						
						<button type="button" class="btn btn-default" onclick="submitForm();">@lang('main.complete')</button>
						<?php } else {?>
						
						<hr/>
						@lang('main.survey_result')
						<br/>
						<br/>
						<?php
							$surveyAction = new SurveyAction();
							$options = $surveyAction->getChartResult($notification->id);
							$sum = 0;
							
							foreach ($options as $option) {
								$sum += $option->chartNumber;
							}
							
							foreach($options as $option) {
								$percent = 0;
								if($option->chartNumber > 0) {
									$percent = round(($option->chartNumber/$sum) * 100);
								}
								echo $percent . '% ' . $option->content . "<br/>";
							}
						?>
						<?php } ?>
					</td>
					<td style="padding-left: 50px">
						<label class="control-label"> 
                        {!! Form::checkbox('isStickyHome') !!} @lang('main.homepage_sticky')
                        </label>
						<br>

						@php
                            $remindDate = "";
                            if($notification->remindDate != null) {
                                $remindDate = \DateTime::createFromFormat('Y-m-d H:i:s', $notification->remindDate)->format('Y-m-d H:i');
                            }
                        @endphp
                        
						<label class="control-label">
                            @if (empty($remindDate))
                                <input type="checkbox" name="remind" id="remind" onClick="turnOnCalender()" />
                            @else
                                <input checked type="checkbox" name="remind" id="remind" onClick="turnOnCalender()" />
                            @endif
                            @lang('main.remind')
                        </label>
                        <br />
                        {!! Form::text('remindDate', $remindDate, [
                            'id' => 'remindDate',
                            'disabled',
                            'class' => 'form-control']) !!}
                        <br />

                        <label class="control-label">
                            @lang('main.notification send_block')
                        </label>
                        {!! Form::select('block_id', $blocks, null, ['class' => 'form-control']) !!}
					</td>
				</tr>
			</tbody>
		</table>
	{!! Form::close() !!}
	<br/>
</div>
@endsection