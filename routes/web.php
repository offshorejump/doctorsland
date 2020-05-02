<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('/', 'PagesController@home')->name('home');

/**
 * User Routs
 **/
Route::get('change_password', 'UsersController@change_password');
Route::put('update_password/{id}', 'UsersController@update_password');

Route::group(['middleware' => ['auth']], function() {

    Route::get('profile/{username}/edit', 'ProfileController@edit');
    Route::put('profile/{username}', 'ProfileController@update');

    Route::group(['middleware' => ['role:admin|manager'], 'prefix' => 'admin'], function() {
        Route::get('users', 'UsersController@index');
        Route::post('users/ajax', 'UsersController@ajax');
        Route::delete('users/{id}', 'UsersController@destroy');
        Route::resource('customers', 'CustomersController');
        Route::post('customers/ajax', 'CustomersController@ajax');
    });
});



/**
 *  Routes: for Users Module
 **/
Route::get('accounts/{type}', 'UsersController@index');
Route::post('accounts/new/{type}', 'UsersController@new_user');
Route::post('accounts/get-user', 'UsersController@get_user_byId');
Route::post('update-user', 'UsersController@update_user');
Route::resource('account/remove', 'UsersController@delete');
Route::get('accounts/{type}/new', 'UsersController@new_account_form');
Route::post('accounts/{type}/add_new', 'UsersController@new_account_post');
Route::get('doctor/new', 'NewDoctorController@index');
Route::post('doctor/add', 'NewDoctorController@add_new_doctor');

/**
 *  Patient routes
 **/
Route::get('patient/list', 'PatientController@index');
Route::resource('patient/new', 'PatientController@new_patient');
Route::resource('patient/add-patient', 'PatientController@add_patient');
Route::post('patient/get-patient', 'PatientController@get_by_Id');
Route::post('patient/update-patient', 'PatientController@update');
Route::post('patient/delete', 'PatientController@delete');
Route::resource('patient/refer', 'ReferController@index');
Route::resource('patient/add-refer', 'ReferController@add');
Route::resource('patient/refered', 'ReferController@referedtodoctor');
Route::get('patient/referedtome', 'ReferController@referedtome');
Route::post('patient/view', 'ReferController@view_by_id');
Route::get('patient/show/{id}', 'ReferController@show_by_id');
Route::get('doctor/view', 'UsersController@doctor_by_id');


/**
 *  Type routes
 **/
Route::get('types/list', 'TypesController@index');
Route::post('types/new', 'TypesController@new_type');
Route::get('types/new_type', 'TypesController@new_type_form');
Route::post('types/add_new', 'TypesController@save_new_type');
Route::post('types/get-type', 'TypesController@get_type');
Route::post('types/update-type', 'TypesController@update_type');


/**
 *  Settings routes
 **/
Route::get('settings/profile', 'ProfileSettingController@get_profile');
Route::post('settings/profile/update', 'ProfileSettingController@update_profile');
Route::post('settings/profile/changepassword/', 'UsersController@update_password');



Route::any('{catchall}', function() {
  echo "404";
})->where('catchall', '.*');
