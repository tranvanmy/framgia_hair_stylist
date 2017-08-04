<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v0', 'namespace' => 'Api'], function() {
    Route::get('get-salons', 'DepartmentsController@index');
    Route::get('get-stylist-by-salonId/{id}', 'UserController@getStylistbySalonID');
    Route::get('get-custommer', 'UserController@getAllCustommerByPage');
    Route::get('first-render-booking', 'ApiController@firstRenderBooking');
    Route::get('get_booking_by_id/{id}', 'OrderBookingController@getBookingbyId');
    Route::get('get_booking_by_user_id/{id}', 'OrderBookingController@getBookingbyUserId');
    Route::get('get_last_booking_by_phone', 'OrderBookingController@getBookingbyPhoneLastest');
    Route::post('user_booking', 'OrderBookingController@userBooking');
    Route::get('booking_filter_by_day', 'OrderBookingController@getBookingFilterByDay');

    Route::get('get-bill-by-customer-id', 'BillController@getBillByCustomerId');

    Route::get('department-create', 'DepartmentsController@createDepartment');
    Route::get('department-edit/{id}', 'DepartmentsController@editDepartment');

    Route::get('filter-order-booking', 'OrderBookingController@filterBooking');

    Route::get('report-sales', 'ReportController@reportSales');
    Route::get('report-bill', 'ReportController@reportBills');

    Route::get('get-render-by-depart-stylist', 'RenderBookingController@getRenderBooking');
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('refresh-token', 'AuthController@refreshToken');
    Route::post('logout', 'AuthController@logout');
    Route::post('send-reset-password', 'AuthController@sendResetLinkEmail');

    Route::resource('service', 'ServiceController');
    Route::resource('user', 'UserController');
    Route::resource('bill', 'BillController');

    Route::get('user-by-phone', 'UserController@getByPhone');
});
