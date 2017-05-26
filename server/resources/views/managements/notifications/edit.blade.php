@extends('managements.master')

@section('content')
<h1 class="page-header">@lang('main.notification')</h1>
<script src="{{ URL::asset('resources/ckeditor/ckeditor.js') }}"></script>
<script src="{{ URL::asset('js/management/notification/edit.js') }}"></script>

<div class="table-responsive">
    <form method="POST" action="{{ route('MM-003') }}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $notification->id }}" />
        <table class="table"> 
            <tbody> 
                <tr> 
                    <td style="width: 60%">
                        <label class="control-label">@lang('main.notification_title')</label>
                        <input type="text" class="form-control" name="title"><br/>
                        
                        <label class="control-label">@lang('main.short_description')</label>
                        <textarea class="form-control" rows="3" rows="33" name="subTitle"></textarea><br/>
                        
                        <label class="control-label">@lang('main.content')</label>
                        <textarea class="form-control" rows="3" rows="33" id="content" name="content"></textarea>
                        <br />
                        <button type="submit" class="btn btn-default">@lang('main.complete')</button>
                    </td>
                    <td>
                        <label class="control-label"> 
                            <input type="checkbox" name="sticky"> @lang('main.homepage_sticky')
                        </label>
                        <br>
                        <label class="control-label"> 
                            <input type="checkbox" name="remind" id="remind" onClick="turnOnCalender()"> @lang('main.remind')
                        </label>
                        <br>
                        <input type="text" name="remindCalender" id="remindCalender" disabled/>
                        <br>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <br/>
</div>
@endsection