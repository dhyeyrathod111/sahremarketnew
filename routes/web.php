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

Auth::routes();
Route::get('/refresh', function() {
	\Artisan::call('clear-compiled');
    \Artisan::call('cache:clear');
	\Artisan::call('config:clear');
	\Artisan::call('config:cache');
	\Artisan::call('optimize:clear');
	\Artisan::call('view:clear');
	\Artisan::call('key:generate');
});


// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@homepage')->name('homepage');


Route::get('/web/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');
Route::get('/web/faq', 'HomeController@faq')->name('faq');
Route::get('/web/career', 'HomeController@career')->name('career');
Route::get('/web/aboutus', 'HomeController@aboutus')->name('aboutus');
Route::get('/web/contact', 'HomeController@contact')->name('contact');
Route::get('/web/termsandconditions', 'HomeController@termsandconditions')->name('termsandconditions');


Route::get('/member/login','AuthenticationController@index')->name('login');
Route::post('/member/loginprocess','AuthenticationController@loginprocess')->name('loginprocess');
Route::get('/member/forgot_password_form', 'AuthenticationController@forgot_password_form')->name('forgot_password_form');
Route::post('/member/forgot_password_process', 'AuthenticationController@forgot_password_process')->name('forgot_password_process');
Route::get('/member/password_reset_form', 'AuthenticationController@password_reset_form')->name('password_reset_form');
Route::post('/member/password_reset_process', 'AuthenticationController@password_reset_process')->name('password_reset_process');

Route::middleware(['checkmemberauth'])->group(function () {

	Route::get('/member/dashboard','DashboardController@index')->name('dashboard');
	Route::get('/member/member_dashboard','DashboardController@member_dashboard')->name('member_dashboard');
	
	Route::get('/member/member_tradereport','DashboardController@member_tradereport')->name('member_tradereport');

	Route::get('/member/logout','DashboardController@logoutmember')->name('logout');
	Route::get('/member/help_center','DashboardController@help_center')->name('help_center');
	Route::post('/member/help_center_process','DashboardController@help_center_process')->name('help_center_process');
	Route::get('/member/download_excel','DashboardController@download_excel')->name('download_excel');

	Route::get('/member/memberlist','MemberController@index')->name('memberlist');
	Route::get('/member/addnewmember','MemberController@create')->name('addnewmember');
	Route::post('/member/process_newmember','MemberController@process_newmember')->name('process_newmember');
	Route::get('/member/member_stocks_foradmin','MemberController@member_stocks_foradmin')->name('member_stocks_foradmin');
	Route::get('/member/delete_member','MemberController@delete_member')->name('delete_member');
	

	Route::get('/member/stock','StockController@index')->name('stock');
	Route::get('/member/stock/addnew','StockController@create')->name('addnewstock');
	Route::post('/member/stock/process_stocks','StockController@store')->name('process_stocks');
	

	Route::get('/member/stock_assignment','StockAssignmentController@index')->name('stock_assignment');
	Route::post('/member/process_stock_assignment','StockAssignmentController@create')->name('process_stock_assignment');
	Route::get('/member/stock_list','StockAssignmentController@stack_list')->name('stock_list_route');
	Route::get('/member/update_single_stock','StockAssignmentController@update_single_stock')->name('update_single_stock');
	Route::post('/member/update_single_stock_process','StockAssignmentController@update_single_stock_process')->name('update_single_stock_process');
	Route::get('/member/download_excel_admin','StockAssignmentController@download_excel_admin')->name('download_excel_admin');


	Route::get('/member/show_ledger_member','MemberledgerController@show_ledger_member')->name('show_ledger_member');
	Route::get('/member/brokerage_calculation','MemberledgerController@brokerage_calculation')->name('brokerage_calculation');

});












	