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
use App\Http\Controllers\GiftController;    
use App\Http\Controllers\ServiceUnitController;
use App\Http\Controllers\PopularOfferController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\GiftCouponController;
use App\Http\Controllers\StaticContentController;
use App\Http\Controllers\MedsapGiftController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\CkeditorController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\InternalOrderController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\GiftsendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccessControlController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;



//For All Backend Route
Route::prefix('admin')->middleware(['auth:web','role:admin'])->group(function () {

    Route::get('/admin-dashboard', [DashboardController::class,'adminDashboard'])->name('dashboard');
    Route::get('/product-dashboard', 'HomeController@ProductDashboard')->name('product-dashboard');
    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/unit-history-of-patient/{unitid}', [DashboardController::class, 'UnitHistoryOfPatient'])->name('unit-history-of-patient');
    
    // ================= SERVICE ORDER HISTORY =================
// Handles service order listing, details, create, update, delete
Route::resource('/service-orders', TransactionHistoryController::class);
Route::post('/service-orders-update', 'TransactionHistoryController@OrderUpdate')->name('service-orders-update');

// ================= COUPON MANAGEMENT =================
// Manage gift coupons (create, edit, delete, list)
Route::resource('/coupon', GiftCouponController::class);

// ================= STATIC CONTENT =================
// CMS pages / static data management
Route::resource('/static-content', StaticContentController::class);

// ================= MEDSPA GIFT =================
// Manage Medspa gift items and related operations
Route::resource('/medspa-gift', MedsapGiftController::class);

// ================= EMAIL TEMPLATE =================
// Manage email templates (create, edit, preview, etc.)
Route::resource('/email-template', EmailTemplateController::class);
Route::get('/email-template/{id}/preview', 'EmailTemplateController@preview')->name('email-template.preview');
Route::post('/email-template/upload-image','EmailTemplateController@uploadImage')->name('email-template.upload-image');

// ================= GIFT =================
// Gift creation, listing, and management
Route::resource('/gift', GiftController::class);
Route::post('/giftcards-history', 'GiftController@history')->name('giftcards-history');
Route::get('/giftcards-view', 'GiftController@redeem_view')->name('giftcards-view');
Route::get('/giftcards-redeem-view', 'GiftController@history_view')->name('giftcards-redeem-view');
Route::post('/giftcards-redeem', 'GiftController@redeem_store')->name('giftcards-redeem');

// ================= SERVICE UNIT =================
// Manage service units (e.g., sessions, packages, etc.)
Route::resource('/unit', ServiceUnitController::class);
Route::post('create-unit-quickly','ServiceUnitController@CreateUnitQuickly')->name('create-unit-quickly');
Route::post('/unit/bulk-action', 'ServiceUnitController@bulkAction')->name('unit.bulk.action');
Route::get('/unit/duplicate/{id}', 'ServiceUnitController@duplicate')->name('unit.duplicate');
Route::get('/unitdelete/{id}','ServiceUnitController@destroy')->name('unitdelete');

// ================= BANNER =================
// Website banners management (upload/update/delete)
Route::resource('/banner', BannerController::class);

// ================= TERMS =================
// Terms & conditions or service-related rules
Route::resource('/terms', TermController::class);
Route::post('/get-units-by-service', "TermController@getUnitsByService")->name('get-units-by-service');

// ================= PROGRAM =================
// Program/package management
Route::resource('/program', ProgramController::class);
Route::get('/program/duplicate/{id}', 'ProgramController@duplicate')->name('program.duplicate');
// Bulk Action
Route::post('/program/bulk-action', 'ProgramController@bulkAction')->name('program.bulk.action');
Route::Get('/program-sale/{id}', 'ProgramController@PatientProgramBuy')->name('program-sale');

// ================= PRODUCT =================
// Product/service management
Route::resource('/product', ProductController::class);
Route::get('/service-search','ProductController@ServiceSearch')->name('service-search');
Route::get('/unit-search','ProductController@UnitSearch')->name('unit-search');
// Single Duplicate
Route::get('/product/duplicate/{id}', 'ProductController@duplicate')->name('product.duplicate');
// Bulk Actions
Route::post('/product/bulk-action', 'ProductController@bulkAction')->name('product.bulk.action');

// ================= PATIENT =================
// Patient records management
Route::resource('/patient', PatientController::class);
// NEW DataTables route (for patient list table)
Route::get('/admin/patient/table-data', [PatientController::class, 'patientTableData'])->name('patient.table.data');
Route::get('/patient-search','PatientController@PatientSearch')->name('patient.search');
Route::post('/patient-import','PatientController@importPatients')->name('patients.import');
Route::get('/giftcards-statement-admin-view/{id}', 'PatientController@GiftcardsStatementAdminView')->name('giftcards-statement-admin-view');
Route::post('/patient-data','PatientController@PatientData')->name('patient-data');
    // Quick PAtient Create
    Route::post('/patient-quick-create',[PatientController::class,'PatientQuickCreate'])->name('patient-quick-create');
// Patient Data Mearge
Route::get('patients/merge-preview', [PatientController::class, 'preview'])->name('patients.merge.preview');
Route::post('patients/merge-execute', [PatientController::class, 'merge'])->name('patients.merge.execute');
Route::get('/patients/merge/preview-swap', [PatientController::class, 'previewSwap'])->name('patients.merge.preview.swap');

// ================= EMPLOYEES =================
// Employee management (CRUD)
Route::resource('employees', EmployeeController::class);
// Employee Managemnent Route
Route::get('employees-table-data', [EmployeeController::class, 'tableData'])->name('employees.table.data');
Route::get('employees.export.pdf', [EmployeeController::class, 'exportPdf'])->name('employees.export.pdf');

// ================= DESIGNATIONS =================
// Employee roles/designations management
Route::resource('designations', DesignationController::class);

// ================= ACCESS CONTROL =================
// Role & permission management
Route::resource('access-control', AccessControlController::class);
Route::get('access-control/get/{id}', [AccessControlController::class, 'getPermissions'])->name('access-control.get-permissions');;
Route::post('access-control/store', [AccessControlController::class, 'storePermissions'])->name('access-control.store-permissions');;

// Route::prefix('admin')->name('admin.')->group(function () {

//     Route::get('access-control/get/{id}', [AccessControlController::class, 'getPermissions'])
//         ->name('access-control.get-permissions');

//     Route::post('access-control/store', [AccessControlController::class, 'storePermissions'])
//         ->name('access-control.store-permissions');
// });

// ================= DEPARTMENTS =================
// Department management
Route::resource('departments', DepartmentController::class);
Route::post('departments/bulk-action', [DepartmentController::class, 'bulkAction'])->name('departments.bulk.action');

// ================= CLINICS =================
// Clinic/location management
Route::resource('clinics', ClinicController::class);
// for Clinic
Route::post('clinics/bulk-action', [ClinicController::class,'bulkAction'])->name('clinics.bulk.action');

// ================= POPULAR OFFERS =================
// Promotional offers management
Route::resource('/popular-offers', PopularOfferController::class);
Route::get('service-cart','PopularOfferController@AdminCartview')->name('service-cart');
Route::get('payment-process','PopularOfferController@AdminPaymentProcess')->name('payment-process');
Route::post('servic-checkout-process','PopularOfferController@CheckoutProcess')->name('servic-checkout-process');
Route::get('/invoice/{transaction_data}', 'PopularOfferController@invoice')->name('service-invoice');

// ================= CATEGORY =================
// Product category management
Route::resource('/category', ProductCategoryController::class);








Route::get('/giftcards-orders','GiftsendController@cardgeneratedList')->name('giftcards-orders');
Route::get('/gift-card-transaction-search','GiftsendController@GifttransactionSearch')->name('gift-card-transaction-search');
Route::get('/giftcardredeem-view','GiftsendController@giftcardredeemView')->name('giftcardredeem-view');
Route::get('/giftcardredeem-from-patientlist/{id}','GiftsendController@giftcardredeemPatientList')->name('giftcardredeemPatientList');
Route::get('/redeem-giftcard/{transaction_id}/{user_id}','GiftsendController@RedeemGiftcard')->name('redeem-giftcard');
Route::get('/giftcardsearch','GiftsendController@GiftCardSearch')->name('giftcard-search');
Route::post('/giftcardredeem','GiftsendController@giftcardredeem')->name('giftcardredeem');
Route::post('/giftcardstatment','GiftsendController@giftcardstatment')->name('giftcardstatment');
Route::get('/giftcards-sale/{id?}', 'GiftsendController@giftsale')->name('giftcards-sale');
Route::post('/giftcancel','GiftsendController@giftcancel')->name('giftcancel');
Route::post('/cardview-route','APIController@cardview')->name('cardview-route');
Route::post('/ckeditor-image-post', 'CkeditorController@uploadImage')->name('ckeditor-image-upload');

Route::view('/email-template-view', 'email.servicePurchaseMail')->name('email-template-view');

 


    Route::post('/categories/import', [ProductCategoryImportController::class, 'import'])->name('categories.import');
    Route::get('/clear-errors', [ProductCategoryImportController::class, 'clearErrors'])->name('clear.errors');
    Route::post('/services/import', [ProductImportController::class, 'import'])->name('services.import');
    Route::post('/upload-multiple-images', [ImageUploadController::class, 'uploadMultipleImages'])->name('upload.images');
    Route::post('/delete-image', [ImageUploadController::class, 'deleteImage']);
    Route::get('/export-categories', [CategoryExportController::class, 'exportCategories']);
    Route::get('/export-categories-with-full-data', [CategoryExportController::class, 'exportCategoriesWithAllFields']);
    Route::get('/export-services', [CategoryExportController::class, 'exportServices']);

    // Service Related Route 
    Route::get('/service-redeem','ServiceOrderController@ServiceRedeemView')->name('service-redeem-view');
    Route::get('/service-redeem-patient-list/{id}','ServiceOrderController@ServiceRedeemPatientList')->name('service-redeem-patient-list');
    Route::post('/redeem-services','ServiceOrderController@ServiceRedeem')->name('redeem-services');
    Route::get('/search-order-api','ServiceOrderController@SearchOrderApi')->name('search-order-api');
    Route::post('/redeemcalculation', 'ServiceOrderController@redeemcalculation')->name('redeemcalculation');
    Route::post('/service-statement', 'ServiceOrderController@getServiceStatement')->name('service-statement');
    Route::post('/redeemedservice', 'ServiceOrderController@redeemedservice')->name('redeemedservice');
    Route::post('/rollback-redeemed-service', 'ServiceOrderController@rollbackRedeemedService')->name('rollback-redeemed-service');

    Route::post('/do-cancel', 'ServiceOrderController@DoCancel')->name('do-cancel');
    Route::get('/cancel-service', 'ServiceOrderController@ServiceCancel')->name('cancel-service');
   
    Route::post('/giftcard-purchase','GiftsendController@GiftPurchase')->name('giftcard-purchase');
    Route::get('/giftcard-purchases-success','GiftsendController@GiftPurchaseSuccess')->name('giftcard-purchases-success');
    Route::post('/giftcard-payment-update','GiftsendController@updatePaymentStatus')->name('giftcard-payment-update');
    Route::get('/resendmail_view','GiftsendController@Resendmail_view')->name('Resendmail_view');
    Route::get('/resendmail_preview','GiftsendController@Resendmail_preview')->name('resendmail_preview');
    Route::post('/resendmail','GiftsendController@Resendmail')->name('resendmail');
    Route::get('search-keywords-reports','ProductController@KeywordsReports')->name('keywords_reports');
    Route::get('export-keywords','ProductController@ExportDate')->name('export_date');

    Route::get('cart-cancel','InternalOrderController@CartCancel')->name('cart-cancel');
    Route::get('change-patient','InternalOrderController@ChangePatient')->name('change-patient');



    Route::post('internal-service-purchase','StripeController@InternalServicePurchase')->name('InternalServicePurchases');





});