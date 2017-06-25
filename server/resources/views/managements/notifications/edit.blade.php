<?php 
use App\Constants\CommonConstant;
?>
@extends('managements.master')

@section('content')
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

<h1 class="page-header">@lang('main.notification')</h1>
<script src="{{ URL::asset('resources/ckeditor/ckeditor.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>
<script src="{{ URL::asset('js/management/notification/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<!-- hidden field -->
<input type="hidden" id="MM-008" value="{{ route('MM-008') }}" />

<div class="table-responsive">
    {!! Form::model($notification , [
        'route' => ['MM-003', $notification->id],
        'method' => 'post',
        'onsubmit' => 'return submitForm()'
    ]) !!}
        {!! Form::hidden('id', null) !!}
        {!! Form::hidden('privateUserList', null, ['id' => 'privateUserList']) !!}
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

                        <div style="margin-bottom: 22px">
                            <label class="control-label">
                                @lang('main.notification send_user')
                            </label>

                            <div id="userTags">
                                @foreach($notification->receivers as $receiver)
                                    <div class="tag btn" user-id="{{ $receiver->user->id }}">
                                        {{ $receiver->user->username }}
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-default" data-toggle="modal"
                                onclick="showUsers()">
                                @lang('main.adding')
                            </button>
                        </div>

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

<!-- Modal -->
<div id="usersModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('main.admin_residential')</h4>
            </div>
            <div class="modal-body" id="usersContainer">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('main.close')</button>
            </div>
        </div>
    </div>
</div>