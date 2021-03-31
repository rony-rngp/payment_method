<?php

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

Route::get('/check', function () {
    return view('check');
});

Route::get('/paypal', function () {
    return view('paypal');
});




Route::group(['middleware'=>'auth'], function(){
	//----------SSlcommerz-----------
	Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
	Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');
	Route::post('/pay', 'SslCommerzPaymentController@index');
	Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax'); 

	//-----------------Stripe-----------
	Route::get('/stripe-payment', 'StripeController@handleGet');
	Route::post('/stripe-payment', 'StripeController@handlePost')->name('stripe.payment');


	//----------Paypal----------
	Route::get('handle-payment', 'PayPalPaymentController@handlePayment')->name('make.payment');
	Route::get('cancel-payment', 'PayPalPaymentController@paymentCancel')->name('cancel.payment');
	Route::get('payment-success', 'PayPalPaymentController@paymentSuccess')->name('success.payment');
});


//----------SSlcommerz-----------
Route::group(['middleware'=>'sslcommerze'], function(){
		Route::post('/success', 'SslCommerzPaymentController@success');
		Route::post('/fail', 'SslCommerzPaymentController@fail');
		Route::post('/cancel', 'SslCommerzPaymentController@cancel');
	});
Route::post('/ipn', 'SslCommerzPaymentController@ipn');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/oneclick', 'HomeController@oneclick')->name('oneclick');
