<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//API
Route::group(['prefix' => 'api',
		'namespace' => 'Api'], function () {
	
	Route::post('/login', 'LoginController@checkAuthentication');
	Route::post('/register', 'LoginController@register');
	Route::get('/getApartments', 'LoginController@getApartments');
	Route::get('/getBlocks/{id?}', 'LoginController@getBlocks');
	Route::get('/getFloors/{id?}', 'LoginController@getFloors');
	Route::get('/getRooms/{id?}', 'LoginController@getRooms');
	
	Route::group(['middleware' => 'auth:api'], function () {
		Route::group(['prefix' => 'notification'], function(){
			Route::get('/stickyHomeNotifications', 'NotificationController@getStickyHomeNotification');
			Route::get('/notificationDetail/{id}', 'NotificationController@getNotificationDetail');
			Route::get('/notificationContentDetail/{id}', 'NotificationController@displayContentDetail');
			Route::get('/survey/{id}', 'NotificationController@getSurveyData');
			Route::post('/survey/save', 'NotificationController@saveResultsSurvey');
			Route::get('/survey/getCompletedSurveyData/{id}', 'NotificationController@getCompletedSurveyData');
			Route::get('/survey/content/{id}', 'NotificationController@displaySurveyContent');
		});
		
		Route::group(['prefix' => 'setting'], function() {
			Route::get('/{id}', 'SettingController@getSettings');
		});
		
		Route::group(['prefix' => 'requirement'], function() {
			Route::post('/save', 'RequirementController@save');
		});
		
		Route::group(['prefix' => 'service'], function() {
			Route::get('/types', 'ServiceController@getTypes');
			Route::get('/list/{serviceType?}', 'ServiceController@getList');
		});
		
		Route::group(['prefix' => 'serviceClick'], function() {
			Route::get('/click/{serviceId}', 'ServiceClickController@click');
		});
		
		Route::group(['prefix' => 'serviceReCall'], function() {
			Route::get('/recall', 'ServiceReCallController@recall');
		});
		
		Route::group(['prefix' => 'serviceCall'], function() {
			Route::get('/getPermission/{serviceId}', 'ServiceCallController@getPermission');
		});

		Route::group(['prefix' => 'user'], function() {
			Route::post('/changePass', 'UserController@changePass');
		});
	});
	
});


Route::group(['namespace' => 'Management'], function () {
    Route::get('/', 'LoginController@show');
});

//Admin Management
Route::group(['prefix' => 'management',
			'namespace' => 'Management'], function() {
	Route::get('/login', 'LoginController@show');
	Route::post('/login', 'LoginController@login')->name('ML-001');
	Route::get('/logout', 'LoginController@logout')->name('ML-002');
});

Route::group(['prefix' => 'management',
			'namespace' => 'Management',
			'middleware' => ['admin']], function() {
	
	Route::group(['prefix' => 'notification'], function(){
		Route::get('/showList', 'NotificationController@showList')->name("MM-001");
		Route::get('/show/{id?}', 'NotificationController@show')->name("MM-002");
		Route::post('/edit', 'NotificationController@edit')->name("MM-003");
		
		Route::get('/showSurveyList', 'NotificationController@showSurveyList')->name("MM-004");
		Route::get('/showSurvey/{id?}', 'NotificationController@showSurvey')->name("MM-005");
		Route::post('/editSurvey', 'NotificationController@editSurvey')->name("MM-006");
		Route::get('/list/json', 'NotificationController@getJsonSurveyList')->name('MM-007');
		Route::post('/remove', 'NotificationController@removeSurvey')->name('MM-008');
		Route::post('/lock', 'NotificationController@lockSurvey')->name('MM-009');
	});
	
	Route::group(['prefix' => 'requirement'], function(){
		Route::get('/showList', 'RequirementController@showList')->name("MR-001");
		Route::get('/show/{id}', 'RequirementController@show')->name("MR-002");
	});
	
	Route::group(['prefix' => 'adminManagement'], function(){
		Route::get('/edit/{id?}', 'AdminManagementController@edit')->name('MA-001');
		Route::post('/edit/save', 'AdminManagementController@save')->name('MA-002');
		Route::get('/editPassword1', 'AdminManagementController@editPassword1')->name('MA-003');
		Route::put('/editPassword1', 'AdminManagementController@updatePassword1')->name('MA-004');
		Route::get('/editPassword2', 'AdminManagementController@editPassword2')->name('MA-005');
		Route::put('/editPassword2', 'AdminManagementController@updatePassword2')->name('MA-006');
	});
	
	Route::group(['prefix' => 'service'], function(){
		Route::get('/showList', 'ServiceController@showList')->name('MSE-001');
		Route::get('/list/json', 'ServiceController@getJsonList')->name('MSE-002');
		Route::get('/edit/{id?}', 'ServiceController@edit')->name('MSE-003');
		Route::post('/remove', 'ServiceController@remove')->name('MSE-004');
		Route::post('/lock', 'ServiceController@lock')->name('MSE-005');
		Route::get('/clickList/json', 'ServiceController@getClickJsonList')->name('MSE-006');
		Route::post('/save', 'ServiceController@save')->name('MSE-007');
	});
	
	Route::group(['prefix' => 'serviceType'], function(){
		Route::get('/showList', 'ServiceTypeController@showList')->name('MSET-001');
		Route::get('/list/json', 'ServiceTypeController@getJsonList')->name('MSET-002');
		Route::get('/edit/{id?}', 'ServiceTypeController@edit')->name('MSET-003');
		Route::post('/remove', 'ServiceTypeController@remove')->name('MSET-004');
		Route::post('/lock', 'ServiceTypeController@lock')->name('MSET-005');
		Route::post('/save', 'ServiceTypeController@save')->name('MSET-006');
	});
	
	Route::group(['prefix' => 'provider'], function(){
		Route::get('/showList', 'ProviderController@showList')->name('MSEP-001');
		Route::get('/list/json', 'ProviderController@getJsonList')->name('MSEP-002');
		Route::get('/edit/{id?}', 'ProviderController@edit')->name('MSEP-003');
		Route::post('/remove', 'ProviderController@remove')->name('MSEP-004');
		Route::post('/lock', 'ProviderController@lock')->name('MSEP-005');
		Route::post('/save', 'ProviderController@save')->name('MSEP-006');
	});
	
	Route::group(['prefix' => 'providerServiceType'], function(){
		Route::get('/list/json/{serviceTypeId?}', 'ProviderServiceTypeController@getJsonList')->name('MPST-001');
	});

	Route::group(['prefix' => 'adminResidential'], function(){
		Route::get('/showList', 'AdminResidentialController@showList')->name('MAR-001');
		Route::get('/list/json', 'AdminResidentialController@getJsonList')->name('MAR-002');
		Route::get('/edit/{id?}', 'AdminResidentialController@edit')->name('MAR-003');
		Route::post('/remove', 'AdminResidentialController@remove')->name('MAR-004');
		Route::post('/lock', 'AdminResidentialController@lock')->name('MAR-005');
		Route::post('/edit/save', 'AdminResidentialController@save')->name('MAR-006');
		Route::get('/floorList/json', 'AdminResidentialController@getJsonFloorList')->name('MAR-007');
		Route::get('/roomList/json', 'AdminResidentialController@getJsonRoomList')->name('MAR-008');
	});

	Route::group(['prefix' => 'apartmentSetting'], function(){
		Route::get('/edit', 'ApartmentSettingController@edit')->name('MAS-001');
		Route::post('/edit/save', 'ApartmentSettingController@save')->name('MAS-002');
		Route::get('/districtList/json', 'ApartmentSettingController@getJsonDistrictList')->name('MAS-003');
		Route::get('/wardList/json', 'ApartmentSettingController@getJsonWardList')->name('MAS-004');
	});
});
