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
    Route::get('/patient-email-verify/{token}',[PatientAuthController::class,'PatientEmailVerify'])->name('patient_email_verify');
    Route::get('/forgot-password',[PatientAuthController::class,'ForgotPasswordView'])->name('forgot-password');
    Route::post('/password-reset',[PatientAuthController::class,'ForgotPassword'])->name('password-reset');
    Route::get('/reset-password/{token}',[PatientAuthController::class,'ResetPassword'])->name('ResetPasswordView');
    Route::post('/reset-password',[PatientAuthController::class,'ResetPasswordPost'])->name('ResetPassword');
    Route::get('/email-suggestions', 'PatientController@emailSuggestions')->name('email-suggestions');
    Route::get('/name-suggestions', 'PatientController@nameSuggestions')->name('name-suggestions');

    Route::view('new_template','layouts.front_new');


// Auth::routes();
Route::get('/login',[AdminController::class,'login'])->name('login');
Route::post('/login',[AdminController::class,'login_post'])->name('login-post');
Route::post('/logout',[AdminController::class,'logout'])->name('logout');
//For All Backend Route
Route::prefix('admin')->middleware('login')->group(function () {
Route::get('/admin-dashboard', 'HomeController@root')->name('root');
Route::get('/product-dashboard', 'HomeController@ProductDashboard')->name('product-dashboard');
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
Route::resource('/gift', GiftController::class);
Route::post('create-unit-quickly','ServiceUnitController@CreateUnitQuickly')->name('create-unit-quickly');
Route::post('/giftcards-history', 'GiftController@history')->name('giftcards-history');
Route::get('/giftcards-view', 'GiftController@redeem_view')->name('giftcards-view');
Route::get('/giftcards-redeem-view', 'GiftController@history_view')->name('giftcards-redeem-view');
Route::post('/giftcards-redeem', 'GiftController@redeem_store')->name('giftcards-redeem');
Route::resource('/service-order-history', TransactionHistoryController::class);
Route::post('/service-order-update', 'TransactionHistoryController@OrderUpdate')->name('service-order-update');
Route::resource('/coupon', GiftCouponController::class);
Route::resource('/static-content', StaticContentController::class);
Route::resource('/medspa-gift', MedsapGiftController::class);
Route::resource('/email-template', EmailTemplateController::class);
Route::post('/ckeditor-image-post', 'CkeditorController@uploadImage')->name('ckeditor-image-upload');
Route::get('/cardgenerated-list','GiftsendController@cardgeneratedList')->name('cardgenerated-list');
Route::get('/gift-card-transaction-search','GiftsendController@GifttransactionSearch')->name('gift-card-transaction-search');
Route::post('/cardview-route','APIController@cardview')->name('cardview-route');
Route::get('/giftcardredeem-view','GiftsendController@giftcardredeemView')->name('giftcardredeem-view');
Route::get('/giftcardredeem-from-patientlist/{id}','GiftsendController@giftcardredeemPatientList')->name('giftcardredeemPatientList');
Route::get('/redeem-giftcard/{transaction_id}/{user_id}','GiftsendController@RedeemGiftcard')->name('redeem-giftcard');
Route::get('/giftcardsearch','GiftsendController@GiftCardSearch')->name('giftcard-search');
Route::post('/giftcardredeem','GiftsendController@giftcardredeem')->name('giftcardredeem');
Route::post('/giftcardstatment','GiftsendController@giftcardstatment')->name('giftcardstatment');
Route::get('/giftcards-sale/{id?}', 'GiftsendController@giftsale')->name('giftcards-sale');
Route::post('/giftcancel','GiftsendController@giftcancel')->name('giftcancel');
Route::resource('/category', ProductCategoryController::class);

Route::resource('/product', ProductController::class);
Route::get('/service-search','ProductController@ServiceSearch')->name('service-search');
Route::get('/unit-search','ProductController@UnitSearch')->name('unit-search');
// Single Duplicate
Route::get('/product/duplicate/{id}', 'ProductController@duplicate')->name('product.duplicate');

// Bulk Actions
Route::post('/product/bulk-action', 'ProductController@bulkAction')->name('product.bulk.action');

// Route::get('/service-buy-from-patient/{id}', 'ProductController@ServiceBuyFromPatientPage')->name('service-buy-from-patient');


Route::resource('/unit', ServiceUnitController::class);
Route::post('/unit/bulk-action', 'ServiceUnitController@bulkAction')->name('unit.bulk.action');
Route::get('/unit/duplicate/{id}', 'ServiceUnitController@duplicate')->name('unit.duplicate');
Route::get('/unitdelete/{id}','ServiceUnitController@destroy')->name('unitdelete');


Route::resource('/banner', BannerController::class);
Route::post('/categories/import', [ProductCategoryImportController::class, 'import'])->name('categories.import');
Route::get('/clear-errors', [ProductCategoryImportController::class, 'clearErrors'])->name('clear.errors');
Route::post('/services/import', [ProductImportController::class, 'import'])->name('services.import');
Route::post('/upload-multiple-images', [ImageUploadController::class, 'uploadMultipleImages'])->name('upload.images');
Route::post('/delete-image', [ImageUploadController::class, 'deleteImage']);
Route::get('/export-categories', [CategoryExportController::class, 'exportCategories']);
Route::get('/export-categories-with-full-data', [CategoryExportController::class, 'exportCategoriesWithAllFields']);
Route::get('/export-services', [CategoryExportController::class, 'exportServices']);
Route::get('/service-redeem','ServiceOrderController@ServiceRedeemView')->name('service-redeem-view');
Route::get('/service-redeem-patient-list/{id}','ServiceOrderController@ServiceRedeemPatientList')->name('service-redeem-patient-list');
Route::post('/redeem-services','ServiceOrderController@ServiceRedeem')->name('redeem-services');
Route::get('/search-order-api','ServiceOrderController@SearchOrderApi')->name('search-order-api');
Route::get('/patient-search','PatientController@PatientSearch')->name('patient.search');
Route::post('/patient-import','PatientController@importPatients')->name('patients.import');
Route::post('/service-statement', 'ServiceOrderController@getServiceStatement')->name('service-statement');
Route::post('/redeemcalculation', 'ServiceOrderController@redeemcalculation')->name('redeemcalculation');
Route::post('/do-cancel', 'ServiceOrderController@DoCancel')->name('do-cancel');
Route::get('/cancel-service', 'ServiceOrderController@ServiceCancel')->name('cancel-service');
Route::resource('/popular-offers', PopularOfferController::class);
Route::post('/giftcard-purchase','GiftsendController@GiftPurchase')->name('giftcard-purchase');
Route::get('/giftcard-purchases-success','GiftsendController@GiftPurchaseSuccess')->name('giftcard-purchases-success');
Route::post('/giftcard-payment-update','GiftsendController@updatePaymentStatus')->name('giftcard-payment-update');
Route::get('/resendmail_view','GiftsendController@Resendmail_view')->name('Resendmail_view');
Route::post('/resendmail','GiftsendController@Resendmail')->name('resendmail');
Route::get('search-keywords-reports','ProductController@KeywordsReports')->name('keywords_reports');
Route::get('export-keywords','ProductController@ExportDate')->name('export_date');
Route::get('service-cart','PopularOfferController@AdminCartview')->name('service-cart');
Route::get('payment-process','PopularOfferController@AdminPaymentProcess')->name('payment-process');
Route::post('servic-checkout-process','PopularOfferController@CheckoutProcess')->name('servic-checkout-process');
Route::get('cart-cancel','InternalOrderController@CartCancel')->name('cart-cancel');
Route::get('change-patient','InternalOrderController@ChangePatient')->name('change-patient');



Route::post('internal-service-purchase','StripeController@InternalServicePurchase')->name('InternalServicePurchases');
Route::get('/invoice/{transaction_data}', 'PopularOfferController@invoice')->name('service-invoice');
Route::get('/giftcards-statement-admin-view/{id}', 'PatientController@GiftcardsStatementAdminView')->name('giftcards-statement-admin-view');
Route::resource('/terms', TermController::class);
Route::post('/get-units-by-service', "TermController@getUnitsByService")->name('get-units-by-service');

Route::resource('/program', ProgramController::class);
// Single Duplicate
Route::get('/program/duplicate/{id}', 'ProgramController@duplicate')->name('program.duplicate');

// Bulk Action
Route::post('/program/bulk-action', 'ProgramController@bulkAction')->name('program.bulk.action');


Route::Get('/program-sale/{id}', 'ProgramController@PatientProgramBuy')->name('program-sale');
Route::resource('/product', ProductController::class);
Route::resource('/patient', PatientController::class);
Route::post('/patient-data','PatientController@PatientData')->name('patient-data');

// NEW DataTables route (for patient list table)
Route::get('/admin/patient/table-data', [PatientController::class, 'patientTableData'])->name('patient.table.data');


// Quick PAtient Create
Route::post('/patient-quick-create',[AdminController::class,'PatientQuickCreate'])->name('patient-quick-create');
});





// Patient Login Form
Route::get('/patient-login',[PatientAuthController::class,'PatientloginView'])->name('patient-login');
Route::post('/patient-login', [PatientAuthController::class, 'PatientLoginPost'])->name('patient-login');
Route::post('/patient-logout', [PatientAuthController::class, 'Patientlogout'])->name('patient-logout');
// For All Patient Route
Route::prefix('My-patient')->middleware('PatientLogin')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'PatientDashboard'])->name('patient-dashboard');
    Route::get('/patient-profile', [PatientController::class, 'PatientProfile'])->name('patient-profile');
    Route::get('/my-giftcards', [PatientController::class, 'Mygiftcards'])->name('my-giftcards');
    Route::get('/giftcards-statement/{id}', [PatientController::class, 'GiftcardsStatement'])->name('giftcards-statement');
    Route::get('/my-services', [PatientController::class, 'Myservices'])->name('my-services');
    Route::get('/patient-invoice/{transaction_data}', [PatientController::class, 'Patientinvoice'])->name('patient-invoice');
});



    
// For Cache Clear
Route::get('/clear', function() {
    Artisan::call('cache:clear ');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    echo Artisan::output();
});


