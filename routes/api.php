<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/coupon-validate','APIController@giftvalidate')->name('coupon-validate');

//  for gift
Route::post('/gift-for-other','APIController@gift_send_store_other')->name('gift-for-other');
Route::post('/gift-for-self','APIController@gift_send_store_self')->name('gift-for-self');
Route::post('/gift-list','APIController@list')->name('gift-list');
Route::post('/gift-card-search','APIController@GiftCardSearch')->name('gift-card-search');
Route::post('/gift-card-validate','APIController@GiftCardvalidate')->name('gift-card-validate');
Route::post('/gift-card-amount-calculation','APIController@GiftCardAmountCalculate')->name('gift-card-amount-calculation');
Route::post('/gift-card-redeem','APIController@GiftCardredeem')->name('gift-card-redeem');
Route::post('/gift-card-statment','APIController@statment')->name('gift-card-statment');
Route::post('/gift-purchase-from-store','APIController@gift_purchase')->name('gift-purchase-from-store');
Route::post('/giftcard-cancel','APIController@cancelgiftcard')->name('giftcard-cancel');


//  for Authentication
Route::post('/auth-login','APIController@authlogin')->name('auth-login');
Route::post('/auth-registration','APIController@authregistration')->name('auth-registration');
Route::post('/auth-forgetpassword','APIController@forgetpassword')->name('auth-forgetpassword');

//  for Transaction 
Route::get('/cardgenerated','APIController@cardgenerated')->name('cardgenerated');
Route::post('/cardview','APIController@cardview')->name('cardview');
Route::post('/giftcard-balance-check','APIController@balancecheck')->name('giftcard-balance-check');
Route::post('/payment_confirmation','APIController@payment_confirmation')->name('payment_confirmation');
Route::post('/payment_status_update','APIController@payment_status_update')->name('payment_status_update');


//  For Product Management 
// Route::resource('/category', ProductCategoryController::class);
Route::post('/category-list', 'APIController@category')->name('category-list');
Route::get('/category/{id}', 'APIController@category_view')->name('category_view');
Route::post('/category-update/{id}', 'APIController@category_update')->name('category_update');
Route::post('/category-created', 'APIController@created')->name('category-created');
Route::post('/categoryDelete/{id}','APIController@categoryDelete')->name('categoryDelete');

// Route for Product

Route::post('/product-list', 'APIController@product')->name('product-list');
Route::get('/product/{id}', 'APIController@product_view')->name('product_view');
Route::post('/product-update/{id}', 'APIController@product_update')->name('product_update');
Route::post('/product-created', 'APIController@productcreated')->name('product-created');
Route::post('/productDelete/{id}','APIController@productDelete')->name('productDelete');


//  For Orders Search
Route::post('/order-search','APIController@OrderSearch')->name('order-search');


// For Patient
Route::post('add-patient','APIController@CreatePatient')->name('add-patient');

