<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => config('constants.general.service_api_prefix'), 'middleware' => ['web']], function () {
    Route::group(['middleware' => ['validateToken']], function () {
        Route::resource('employees', 'Admin\EmployeesController');
        Route::post('employees/delete', 'Admin\EmployeesController@deleteEmployee');
        Route::post('employees/resignEmployee', 'Admin\EmployeesController@deleteEmployee');

        Route::resource('branches', 'Admin\BranchesController');
        Route::post('branches/delete', 'Admin\BranchesController@deleteBranch');
    });
    Route::post('login', 'Admin\UserController@userLogin');
});

Route::any('{path?}', function () {

    return view("index");

})->where("path", ".+");

