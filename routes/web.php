<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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



Route::get('/adminreg', 'AdminRegMailController@addadmin')->name('adminregister');

Route::get('/docrequests', 'DoctorController@docrequests');

Route::post('/requests/accept', 'DoctorController@acceptrequest');

Route::post('/requests/reject', 'DoctorController@rejectrequest');

Route::get('/departments', 'DepartmentsController@index');

Route::post('/dptdel/{id}','DepartmentsController@dptdel');

Route::post('/dptadd','DepartmentsController@add');

Route::post('/docinfo','DoctorController@docinfo');

Route::post('/sendlink','AdminRegMailController@sendEmail');

Route::get('initadmin/{key}/{email}','AdminRegMailController@firstadmin');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/home/profile','HomeController@profile');

Route::post('/savechanges','ProfileController@savechanges');

Route::post('/update','ProfileController@update');

Route::post('/changepassword','ProfileController@pwchange');

Route::post('/changemail','ProfileController@emailchange');

Route::post('/home/dpupload','HomeController@dpupload');

Route::post('/home/dpdel','HomeController@dpdel');

Route::get('/clientlist','UserList@clientlist');

Route::get('/doctorlist','UserList@doctorlist');

Route::get('/activedocs','DoctorController@activedocs');

Route::post('/activedocs/filter','DoctorController@activedocs');

Route::get('/adminlist','UserList@adminlist');

Route::get('/appointment/{email}','AppointmentController@makeappointment');

Route::get('/appointment/{email}/{appointment}/reschedule','AppointmentController@rescheduleappointment');

Route::post('/confirmreschedule','AppointmentController@confirmreschedule');

Route::post('/confirmappointment','AppointmentController@confirmappointment');

Route::post('/newclient','BalanceController@newclient');

Route::post('/newdoctor','BalanceController@newdoctor');

Route::get('/topup','Transactioncontroller@topupview');

Route::post('/topupreq','BalanceController@topupreq');

Route::get('/topuprequests','BalanceController@topuprequests');

Route::post('/verifytopup','TransactionController@verifytopup');

Route::post('/rejecttopup','TransactionController@rejecttopup');

Route::get('/cashout','BalanceController@cashoutview');

Route::post('/cashoutreq','BalanceController@cashoutreq');

Route::get('/cashoutrequests','BalanceController@cashoutrequests');

Route::post('/verifycashout','TransactionController@verifycashout');

Route::get('/transactions','TransactionController@transactions');

Route::get('/appointmentsreport','AppointmentController@appreport');

Route::get('/appointment/details/{appid}','AppointmentController@details');

Route::post('/appointment/cancel','AppointmentController@cancelappointment');

Route::get('/flagattended/{appointment}','AppointmentController@flagasattended');

Route::get('/alltransactions','TransactionController@all');

Route::get('/allappointments','AppointmentController@allappointments');

