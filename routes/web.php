<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientAuthController;
use App\Http\Controllers\ProductCategoryImportController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\CategoryExportController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

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

Route::view('email','email.giftcard');
Route::post('/checkusername',[PatientAuthController::class,'CheckUserName'])->name('checkusername');
Route::post('/patient-signup',[PatientAuthController::class,'PatientSignup'])->name('patient-signup');
// All Frontend Route Start
Route::get('/',[App\Http\Controllers\GiftController::class,'HOME'])->name('home');
Route::get('product-page/{token?}/{slug}', 'ProductController@productpage')->name('product_list');
Route::get('productdetails/{slug}','ProductController@productdetails')->name('productdetails');
Route::get('services','ServiceUnitController@ServicePage')->name('services');
Route::get('category/{slug}','ProductCategoryController@categorytpage')->name('treatment-categories');
Route::get('services/{slug}','ServiceUnitController@UnitPageShow')->name('serviceunit');// This is  For Service Frontend and Backend Banner Service
Route::get('services/{product_slug}/{unitslug}','ServiceUnitController@UnitPageDetails')->name('unit-details');
Route::get('service/{slug}','ProductController@productdetails')->name('productdetails');
Route::post('services-search','ProductController@ServicesSearch')->name('ServicesSearch');
Route::get('popular-service/{id}','ProductController@PopularService')->name('PopularService');
Route::get('popular-deals','PopularOfferController@popularDeals')->name('popularDeals');
Route::post('cart','PopularOfferController@Cart')->name('cart');
Route::get('cartview','PopularOfferController@Cartview')->name('cartview');
Route::post('/cart/remove','PopularOfferController@CartRemove')->name('cartremove');
Route::post('/update-cart', 'PopularOfferController@updateCart')->name('update-cart');
Route::get('checkout','PopularOfferController@Checkout')->name('checkout');
Route::get('checkout-view','PopularOfferController@checkoutView')->name('checkout_view');
Route::post('/giftcards-validate', 'GiftsendController@giftcardValidate')->name('giftcards-validate');
Route::post('checkout-process','StripeController@CheckoutProcess')->name('checkout_process');
Route::get('stripe/checkout/success','StripeController@stripcheckoutSuccess')->name('strip_checkout_success');
Route::post('createslug','ProductCategoryController@slugCreate')->name('slugCreate');
Route::get('find-deals','ProductCategoryController@FindDeals')->name('find-deals');
Route::get('invoice','StripeController@invoice')->name('invoice');
Route::get('/generate-pdf/{id}', [PDFController::class, 'generatePDF']);
//  New Code For API URL Call
Route::post('/sendgift','GiftsendController@sendgift')->name('sendgift');
Route::post('/selfgift','GiftsendController@selfgift')->name('selfgift');
Route::post('/coupon-verify','GiftsendController@giftvalidate')->name('coupon-verify');
Route::post('/giftcardpayment',[App\Http\Controllers\StripeController::class,'giftcardpayment'])->name('giftcardpayment');
Route::post('/balance-check','GiftsendController@knowbalance')->name('balance-check');
Route::post('/payment_cnf','GiftsendController@payment_confirmation')->name('payment_cnf');
Route::post('/cart/clear', 'PopularOfferController@clearCart')->name('cart.clear');
// Route::get('services/{slug}','ProductController@productpage')->name('product');
route::get('/db','GiftController@DBview')->name('dbview');
//  For Payment Route
Route::post('/send-gift-cards','GiftController@store')->name('send-gift-cards');
Route::get('/strip_form',[App\Http\Controllers\StripeController::class,'formview']);
Route::post('/payment',[App\Http\Controllers\StripeController::class,'makepayment']);
Route::get('/success', function () {
    return view('stripe.thanks');
});
Route::get('/failed', function () {
    return view('stripe.failed');
});
//  Usefull Route
Route::post('/store-amount', 'PatientController@storeAmount')->name('store-amount');
Route::post('/unset-amount', 'PatientController@unsetAmont')->name('unset-amount');
Route::get('/remove-amount', 'PatientController@removeAmount')->name('remove-amount');
Route::get('/patient-email-verify/{token}',[PatientAuthController::class,'PatientRegistrationConfirm'])->name('patient_email_verify');
Route::get('/forgot-password',[PatientAuthController::class,'ForgotPasswordView'])->name('forgot-password');
Route::post('/password-reset',[PatientAuthController::class,'ForgotPassword'])->name('password-reset');
Route::get('/reset-password/{token}',[PatientAuthController::class,'ResetPassword'])->name('ResetPasswordView');
Route::post('/reset-password',[PatientAuthController::class,'ResetPasswordPost'])->name('ResetPassword');
Route::get('/email-suggestions', 'PatientController@emailSuggestions')->name('email-suggestions');
Route::get('/name-suggestions', 'PatientController@nameSuggestions')->name('name-suggestions');
Route::view('new_template','layouts.front_new');


// Patient Login Form
Route::get('/patient-login',[PatientAuthController::class,'PatientloginView'])->name('patient-login');
Route::post('/patient-login', [PatientAuthController::class, 'PatientLoginPost'])->name('patient-login');
Route::post('/patient-logout', [PatientAuthController::class, 'Patientlogout'])->name('patient-logout');


// Auth::routes();
Route::get('/login',[LoginController::class,'showLogin'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login-post');
Route::post('/logout',[LoginController::class,'logout'])->name('logout');


// For Employee Panel
Route::prefix('employee')->middleware(['auth:web','role:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');

});

// For Cache Clear
Route::get('/clear', function() {
    Artisan::call('cache:clear ');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    echo Artisan::output();
});


