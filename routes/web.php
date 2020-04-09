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

Auth::routes();
Route::get('/billing', 'HomeController@billing')->name('billing');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('post_upload_excel', 'HomeController@post_upload_excel')->name('post_upload_excel');
Route::post('download_excel', 'HomeController@download_excel')->name('download_excel');
Route::post('post_upload_excel_cv_number', 'HomeController@post_upload_excel_cv_number')->name('post_upload_excel_cv_number');

Route::post('post_upload_billing_excel', 'HomeController@post_upload_billing_excel')->name('post_upload_billing_excel');
Route::post('post_upload_excel_billing_finance', 'HomeController@post_upload_excel_billing_finance')->name('post_upload_excel_billing_finance');
Route::post('download_excel_billing_new', 'HomeController@download_excel_billing_new')->name('download_excel_billing_new');

Route::post('clear_excel', 'HomeController@clear_excel')->name('clear_excel');

Route::get('/interest', 'HomeController@interest')->name('interest');
Route::post('post_upload_member_interest', 'HomeController@post_upload_member_interest')->name('post_upload_member_interest');
Route::post('post_update_interest', 'HomeController@post_update_interest')->name('post_update_interest');
Route::post('download_excel_interest', 'HomeController@download_excel_interest')->name('download_excel_interest');
Route::post('clear_excel_interest', 'HomeController@clear_excel_interest')->name('clear_excel_interest');
