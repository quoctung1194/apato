<?php 
use App\Constants\CommonConstant;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard Template for Bootstrap</title>
        <!-- Bootstrap core CSS -->
        <link href="{{ URL::asset('resources/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="{{  URL::asset('css/dashboard.css?v=0.1') }}" rel="stylesheet">
        <link href="{{  URL::asset('resources/dateTimePicker/jquery.datetimepicker.css') }}" rel="stylesheet">
        <!-- Font awesome -->
        <link rel="stylesheet" href="{{ URL::asset('resources/fontAwesome/css/font-awesome.css?v=' . CommonConstant::RESOURCE_VERSION) }}">
        <!-- Javascript -->
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('resources/dateTimePicker/jquery.datetimepicker.full.min.js') }}"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php
                    	$admin = auth()->guard('admin')->user();
                    	$apartment = $admin->apartment;
                    ?>
                    <a class="navbar-brand" href="#">
                    @if($admin->is_super_admin == 1)
                    Super Admin Dashboard
                    @else
                    {{ mb_strtoupper($apartment->name, 'UTF-8') }}
                    @endif
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li>
                            <a href="#">Settings</a>
                        </li>
                        <li>
                            <a href="#">Profile</a>
                        </li>
                        <li>
                            <a href="#">Help</a>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-right">
                        <input type="text" class="form-control" placeholder="Search...">
                    </form>
                </div>
            </div>
        </nav>
        <div class="container-fluid" >
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
<!--                      class="active" -->
                    	@if($admin->is_super_admin == 0)
                        <li {{ ($menu == 'MN') ? 'class=active' : '' }}>
                            <a href="{{ route('MM-001') }}">@lang('main.notification')<span class="sr-only">(current)</span></a>
                        </li>
                        <li {{ ($menu == 'MS') ? 'class=active' : '' }}>
                            <a href="{{ route('MM-004') }}">@lang('main.opinion_survey')</a>
                        </li>
                        <!-- <li>
                            <a href="#">Cư dân chung cư<br></a>
                        </li> -->
                        <li {{ ($menu == 'MR') ? 'class=active' : '' }}>
                            <a href="{{ route('MR-001') }}">@lang('main.requirement')</a>
                        </li>
                        <li {{ ($menu == 'MAR') ? 'class=active' : '' }}>
                            <a href="{{ route('MAR-001') }}">@lang('main.admin_residential')</a>
                        </li>
                        @endIf
                        @if($admin->is_super_admin == 1)
                         <li {{ ($menu == 'MSET') ? 'class=active' : '' }}>
                            <a href="{{ route('MSET-001') }}">@lang('main.service_type')</a>
                         </li>
                         <li {{ ($menu == 'MSEP') ? 'class=active' : '' }}>
                            <a href="{{ route('MSEP-001') }}">@lang('main.provider')</a>
                         </li>
                         <li {{ ($menu == 'MSE') ? 'class=active' : '' }}>
                            <a href="{{ route('MSE-001') }}">@lang('main.service')</a>
                         </li>
                        @endIf
                        <li {{ ($menu == 'MA') ? 'class=active' : '' }}>
                            <a href="{{ route('MA-001') }}">@lang('main.admin_management')</a>
                        </li>
                        <li {{ ($menu == 'MAS') ? 'class=active' : '' }}>
                            <a href="{{ route('MAS-001') }}">@lang('main.apartment_setting')</a>
                        </li>
                        <li>
                            <a href="{{ route('ML-002') }}">@lang('main.logout')</a>
                        </li>
                    </ul>
                </div>
                 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					@yield('content')
				</div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
        <script src="{{ URL::asset('resources/bootstrap/js/bootstrap.min.js') }}"></script>
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="{{ URL::asset('js/ie10-viewport-bug-workaround.js') }}"></script>
    </body>
</html>
