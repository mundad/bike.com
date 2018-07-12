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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');*/

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/biketype', 'BiketypeController@show')->name('show_biketype');
Route::get('/biketype/addform', 'BiketypeController@addform')->name('addform_biketype');
Route::post('/biketype/save', 'BiketypeController@save')->name('save_biketype');
Route::match(['get','post'],'/biketype/change', 'BiketypeController@change')->name('change_biketype');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/agent', 'AgentController@show')->name('show_agent');
Route::get('/agent/addform', 'AgentController@addform')->name('addform_agent');
Route::post('/agent/save', 'AgentController@save')->name('save_agent');
Route::match(['get','post'],'/agent/change', 'AgentController@change')->name('change_agent');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/rentalbike', 'RentalController@show')->name('show_rentalbike');
Route::get('/rentalbike/addform', 'RentalController@addform')->name('addform_rentalbike');
Route::post('/rentalbike/save', 'RentalController@save')->name('save_rentalbike');
Route::post('/rentalbike/change', 'RentalController@change')->name('change_rentalbike');/**/
Route::get('/rentalbike/print', 'RentalController@print')->name('print_rentalbike');
Route::post('/rentalbike/print', 'RentalController@print')->name('print_rentalbike');
Route::post('/rentalbike/search', 'RentalController@search')->name('search_rentalbike');
Route::post('/rentalbike/in', 'RentalController@in')->name('in_rentalbike');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/report', 'ReporttController@show')->name('show_report');
Route::get('/report/agents', 'ReporttController@agentsshow')->name('agentsshow_report');
Route::get('/report/users', 'ReporttController@usershow')->name('usershow_report');
Route::get('/report/users/rental/change', 'ReporttController@changerent')->name('changerent_report');
Route::post('/report/users/rental/change', 'ReporttController@searchchangerent')->name('searchchangerent_report');
Route::post('/report/users/rep', 'ReporttController@ruser')->name('ruser_report');
Route::post('/report/users/rental', 'ReporttController@usersearch')->name('urentsearch_report');
Route::post('/report/paid/agent', 'ReporttController@pagent')->name('pagent_report');
Route::post('/report/paid/agent/save', 'ReporttController@savepaid')->name('savepaid_report');
Route::post('/report/search', 'ReporttController@search')->name('search_report');
Route::post('/report/agentpaid/search', 'ReporttController@paidsearch')->name('paidsearch_report');



///////////////////////////////////////////////////////////////////////
Route::get('/json/biketype','JsonSenderController@biketype');
Route::get('/json/user/{phone}','JsonSenderController@user_get')->where('phone', '[0-9]+');