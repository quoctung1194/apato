<?php 
use App\Constants\CommonConstant;
?>

@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.notification')</h1>
<script src="{{ URL::asset('resources/ckeditor/ckeditor.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('js/management/notification/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<div class="table-responsive">
    {!! Form::model($notification , ['route' => ['MM-003', $notification->id], 'method' => 'post']) !!}
        {!! Form::hidden('id', null) !!}
        <table class="table"> 
            <tbody> 
                <tr> 
                    <td style="width: 60%">
                        <label class="control-label">@lang('main.notification_title')</label>
                        {!! Form::text('title', null, ['class' => 'form-control']) !!}<br/>
                        
                        <label class="control-label">@lang('main.short_description')</label>
                        {!! Form::textarea('subTitle', null, ['class' => 'form-control', 'rows' => 3]) !!}<br/>
                        
                        <label class="control-label">@lang('main.content')</label>
                        {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 3]) !!}<br/>
                        <button type="submit" class="btn btn-default">@lang('main.complete')</button>
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