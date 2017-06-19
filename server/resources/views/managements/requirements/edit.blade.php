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

<script src="{{ URL::asset('js/management/requirement/edit.js?v=' . CommonConstant::RESOURCE_VERSION) }}"></script>

<input type="hidden" id="current_route" value="{{URL::route('MR-002')}}" />

<h1 class="page-header">@lang('main.requirement')</h1>
<div class="table-responsive">
    <form id="editForm" method="POST" action="{{ route('MR-003') }}" onsubmit="return false">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $requirement->id }}" />
        <input type="hidden" name="user_id" value="{{ $requirement->user_id }}" />
        <table style="width: 60%"> 
            <tbody>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.title')</label>
                        <input type="text" class="form-control" name="title" value="{{ $requirement->title }}"/>
                        <label name='validate' value='title_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.created_at')</label>
                        <?php
                            $created_at = $requirement->created_at ? substr($requirement->created_at, 0, 11) : "";
                        ?>
                        <input type="text" class="form-control" id="created_at" name="created_at" value="{{ $created_at}}"/>
                        <label name='validate' value='created_at_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.type')</label>
                        <select id="type" class="form-control" name="type" >
                            <option></option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}"
                                    <?php
                                    if($requirement->type_id === $type->id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $type->content}}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='type_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.tag')</label>
                        <select id="tag" class="form-control" name="tag" >
                            <option></option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    <?php
                                    if($requirement->tag_id === $tag->id) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $tag->content }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='tag_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.repeat_problem')</label>
                        <select class="form-control" id="is_repeat_problem" name="is_repeat_problem" value="">
                            <?php
                            $listRepeatProblem = array(
                                '0' => 'Không',
                                '1' => 'Có',
                            );
                            ?>
                            <option></option>
                            @foreach($listRepeatProblem as $key => $value)
                                <option value="{{ $key }}"
                                    <?php
                                    if($key === $requirement->is_repeat_problem) {
                                        echo 'selected';
                                    }
                                    ?>
                                >
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        <label name='validate' value='is_repeat_problem_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="control-label">@lang('main.content')</label>
                        <textarea class="form-control" rows="6" name="description">{{ $requirement->description }}</textarea>
                        <label name='validate' value='description_error' style="color: red"></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label" >
                            <input type="checkbox" name="locked" {{ $requirement->locked != 0 ? 'checked' : '' }}/>
                            @lang('main.lock')
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        @foreach($requirement->requirementImages as $image)
                            <a target="_blank" href="{{ URL::asset($image->path) }}">
                                <img src="{{ URL::asset($image->path) }}"
                                    class="img-rounded" style="object-fit: contain" alt="Cinque Terre" width=80 height="80">
                            </a>
                        @endforeach
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