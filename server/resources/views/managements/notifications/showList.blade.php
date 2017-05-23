<?php 
use App\Constants\CommonConstant;
?>
@extends('managements.master')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('resources/fontAwesome/css/font-awesome.css?v=' . CommonConstant::RESOURCE_VERSION) }}">

<h1 class="page-header">@lang('main.notification')</h1>
<div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
        <a href="{{ route('MM-002') }}" type="button" class="btn btn-default buttonCreate">@lang('main.add_new')</a>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder"></div>
    <div class="col-xs-6 col-sm-3 placeholder"></div>
    <div class="col-xs-6 col-sm-3 placeholder"></div>
</div>
<h2 class="sub-header">@lang('main.notification_list')</h2>
<div class="table-responsive">
    <table id="notificationTable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('main.notification_title')</th>
                <th>@lang('main.created_at')</th>
                <th>@lang('main.created_by')</th>
                <th>@lang('main.type')</th>
                <th>@lang('main.remind_date')</th>
                <th>@lang('main.action')</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($notifications as $notification)
            <tr>
                <td>{{ $notification->id }}</td>
                <td>{{ $notification->title }}</td>
                <td>{{ $notification->created_at->format('d-m-Y') }}</td>
                <td>Update later</td>
                <?php
                    if($notification->privacyType == '0') {
                        $privacy = "Chung";
                    } else {
                        $privacy = "Riêng tư";
                    }
                ?>
                <td>
                {{ $privacy }}
                </td>
                <?php
                if(!empty($notification->remindDate)) {
                    $dateTime = strtotime($notification->remindDate);
                    $remindDate = date('d-m-Y', $dateTime);
                } else {
                    $remindDate = "None";
                }
                ?>
                <td>{{ $remindDate }}</td>
                <td>
                    <a href="{{ route('MM-002', ['id' => $notification->id]) }}">
                        <i class="fa fa-pencil" aria-hidden="true" title="Edit"></i>&nbsp;&nbsp;
                    </a>
                    <i class="fa fa-trash" aria-hidden="true" title="Remove"></i>&nbsp;&nbsp;
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