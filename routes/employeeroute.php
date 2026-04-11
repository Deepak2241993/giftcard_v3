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

Route::prefix('employee')->middleware(['auth:web','role:employee'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');

// ================= CATEGORY =================
Route::get('/category', [ProductCategoryController::class, 'index'])
->middleware('permission:view_categories')
->name('employee.category.index');

Route::get('/category/create', [ProductCategoryController::class, 'create'])
->middleware('permission:create_categories')
->name('employee.category.create');

Route::post('/category', [ProductCategoryController::class, 'store'])
->middleware('permission:create_categories')
->name('employee.category.store');

Route::get('/category/{id}/edit', [ProductCategoryController::class, 'edit'])
->middleware('permission:edit_categories')
->name('employee.category.edit');

Route::put('/category/{id}', [ProductCategoryController::class, 'update'])
->middleware('permission:edit_categories')
->name('employee.category.update');

Route::delete('/category/{id}', [ProductCategoryController::class, 'destroy'])
->middleware('permission:delete_categories')
->name('employee.category.destroy');

  // ================= UNIT =================
Route::get('/unit', [ServiceUnitController::class, 'index'])
->middleware('permission:view_units')
->name('employee.unit.index');

Route::get('/unit/create', [ServiceUnitController::class, 'create'])
->middleware('permission:create_units')
->name('employee.unit.create');

Route::post('/unit', [ServiceUnitController::class, 'store'])
->middleware('permission:create_units')
->name('employee.unit.store');

Route::get('/unit/{id}/edit', [ServiceUnitController::class, 'edit'])
->middleware('permission:edit_units')
->name('employee.unit.edit');

Route::put('/unit/{id}', [ServiceUnitController::class, 'update'])
->middleware('permission:edit_units')
->name('employee.unit.update');

Route::delete('/unit/{id}', [ServiceUnitController::class, 'destroy'])
->middleware('permission:delete_units')
->name('employee.unit.destroy');

Route::get('cart-cancel','InternalOrderController@CartCancel')->name('employee.cart-cancel');
Route::get('service-cart','PopularOfferController@AdminCartview')->name('employee.service-cart');
Route::post('cart','PopularOfferController@Cart')->name('employee.cart');
Route::get('cartview','PopularOfferController@Cartview')->name('employee.cartview');
Route::post('/cart/remove','PopularOfferController@CartRemove')->name('employee.cartremove');
Route::post('/update-cart', 'PopularOfferController@updateCart')->name('employee.update-cart');
Route::get('/unit-search','ProductController@UnitSearch')->name('employee.unit-search');
Route::post('/unit/bulk-action', 'ServiceUnitController@bulkAction')->name('employee.unit.bulk.action');
Route::get('/unit/duplicate/{id}', 'ServiceUnitController@duplicate')->name('employee.unit.duplicate');
Route::get('/unitdelete/{id}','ServiceUnitController@destroy')->name('employee.unitdelete');

// ================= PRODUCT =================
Route::get('/product', [ProductController::class, 'index'])
->middleware('permission:view_products')
->name('employee.product.index');

Route::get('/product/create', [ProductController::class, 'create'])
->middleware('permission:create_products')
->name('employee.product.create');

Route::post('/product', [ProductController::class, 'store'])
->middleware('permission:create_products')
->name('employee.product.store');

Route::get('/product/{id}', [ProductController::class, 'show'])
->middleware('permission:view_products')
->name('employee.product.show');

Route::get('/product/{id}/edit', [ProductController::class, 'edit'])
->middleware('permission:edit_products')
->name('employee.product.edit');

Route::put('/product/{id}', [ProductController::class, 'update'])
->middleware('permission:edit_products')
->name('employee.product.update');

Route::delete('/product/{id}', [ProductController::class, 'destroy'])
->middleware('permission:delete_products')
->name('employee.product.destroy');

Route::get('/product/duplicate/{id}', 'ProductController@duplicate')->name('employee.product.duplicate');
Route::post('/product/bulk-action', 'ProductController@bulkAction')->name('employee.product.bulk.action');

// ================= SERVICE ORDER =================

Route::get('/service-orders', [TransactionHistoryController::class, 'index'])
->middleware('permission:view_service_orders')
->name('employee.service-orders.index');

Route::get('/service-orders/create', [TransactionHistoryController::class, 'create'])
->middleware('permission:create_service_orders')
->name('employee.service-orders.create');

Route::post('/service-orders', [TransactionHistoryController::class, 'store'])
->middleware('permission:create_service_orders')
->name('employee.service-orders.store');

Route::get('/service-orders/{id}', [TransactionHistoryController::class, 'show'])
->middleware('permission:view_service_orders')
->name('employee.service-orders.show');

Route::get('/service-orders/{id}/edit', [TransactionHistoryController::class, 'edit'])
->middleware('permission:edit_service_orders')
->name('employee.service-orders.edit');

Route::put('/service-orders/{id}', [TransactionHistoryController::class, 'update'])
->middleware('permission:edit_service_orders')
->name('employee.service-orders.update');

Route::delete('/service-orders/{id}', [TransactionHistoryController::class, 'destroy'])
->middleware('permission:delete_service_orders')
->name('employee.service-orders.destroy');


    // ================= COUPON =================
Route::get('/coupon', [GiftCouponController::class, 'index'])
->middleware('permission:view_gift_card_coupons')
->name('employee.coupon.index');

Route::get('/coupon/create', [GiftCouponController::class, 'create'])
->middleware('permission:create_gift_card_coupons')
->name('employee.coupon.create');

Route::post('/coupon', [GiftCouponController::class, 'store'])
->middleware('permission:create_gift_card_coupons')
->name('employee.coupon.store');

Route::get('/coupon/{id}', [GiftCouponController::class, 'show'])
->middleware('permission:view_gift_card_coupons')
->name('employee.coupon.show');

Route::get('/coupon/{id}/edit', [GiftCouponController::class, 'edit'])
->middleware('permission:edit_gift_card_coupons')
->name('employee.coupon.edit');

Route::put('/coupon/{id}', [GiftCouponController::class, 'update'])
->middleware('permission:edit_gift_card_coupons')
->name('employee.coupon.update');

Route::delete('/coupon/{id}', [GiftCouponController::class, 'destroy'])
->middleware('permission:delete_gift_card_coupons')
->name('employee.coupon.destroy');

    // ================= STATIC CONTENT =================

Route::get('/static-content', [StaticContentController::class, 'index'])
->middleware('permission:view_static_contents')
->name('employee.static-content.index');

Route::get('/static-content/create', [StaticContentController::class, 'create'])
->middleware('permission:create_static_contents')
->name('employee.static-content.create');

Route::post('/static-content', [StaticContentController::class, 'store'])
->middleware('permission:create_static_contents')
->name('employee.static-content.store');

Route::get('/static-content/{id}', [StaticContentController::class, 'show'])
->middleware('permission:view_static_contents')
->name('employee.static-content.show');

Route::get('/static-content/{id}/edit', [StaticContentController::class, 'edit'])
->middleware('permission:edit_static_contents')
->name('employee.static-content.edit');

Route::put('/static-content/{id}', [StaticContentController::class, 'update'])
->middleware('permission:edit_static_contents')
->name('employee.static-content.update');

Route::delete('/static-content/{id}', [StaticContentController::class, 'destroy'])
->middleware('permission:delete_static_contents')
->name('employee.static-content.destroy');

// ================= TERMS =================   
Route::get('/terms', [TermController::class, 'index'])
->middleware('permission:view_terms_and_conditions')
->name('employee.terms.index');

Route::get('/terms/create', [TermController::class, 'create'])
->middleware('permission:create_terms_and_conditions')
->name('employee.terms.create');

Route::post('/terms', [TermController::class, 'store'])
->middleware('permission:create_terms_and_conditions')
->name('employee.terms.store');

Route::get('/terms/{id}', [TermController::class, 'show'])
->middleware('permission:view_terms_and_conditions')
->name('employee.terms.show');

Route::get('/terms/{id}/edit', [TermController::class, 'edit'])
->middleware('permission:edit_terms_and_conditions')
->name('employee.terms.edit');

Route::put('/terms/{id}', [TermController::class, 'update'])
->middleware('permission:edit_terms_and_conditions')
->name('employee.terms.update');

Route::delete('/terms/{id}', [TermController::class, 'destroy'])
->middleware('permission:delete_terms_and_conditions')
->name('employee.terms.destroy');

Route::post('get-units-by-service', [TermController::class, 'getUnitsByService'])
->middleware('permission:delete_terms_and_conditions')
->name('employee.get-units-by-service');



   // ================= EMAIL TEMPLATE =================
 
Route::get('/email-template', [EmailTemplateController::class, 'index'])
->middleware('permission:view_email_templates')
->name('employee.email-template.index');

Route::get('/email-template/create', [EmailTemplateController::class, 'create'])
->middleware('permission:create_email_templates')
->name('employee.email-template.create');

Route::post('/email-template', [EmailTemplateController::class, 'store'])
->middleware('permission:create_email_templates')
->name('employee.email-template.store');

Route::get('/email-template/{id}', [EmailTemplateController::class, 'show'])
->middleware('permission:view_email_templates')
->name('employee.email-template.show');

Route::get('/email-template/{id}/edit', [EmailTemplateController::class, 'edit'])
->middleware('permission:edit_email_templates')
->name('employee.email-template.edit');

Route::put('/email-template/{id}', [EmailTemplateController::class, 'update'])
->middleware('permission:edit_email_templates')
->name('employee.email-template.update');

Route::delete('/email-template/{id}', [EmailTemplateController::class, 'destroy'])
->middleware('permission:delete_email_templates')
->name('employee.email-template.destroy');

Route::get('/email-template/{id}/preview', [EmailTemplateController::class, 'preview'])->name('employee.email-template.preview')->middleware('permission:view_email_templates');
Route::post('/email-template/upload-image',[EmailTemplateController::class, 'uploadImage'])->name('employee.email-template.upload-image')->middleware('permission:edit_email_templates');

// ================= BANNER =================
    Route::get('/banner', [BannerController::class, 'index'])
->middleware('permission:view_sliders')
->name('employee.banner.index');

Route::get('/banner/create', [BannerController::class, 'create'])
->middleware('permission:create_sliders')
->name('employee.banner.create');

Route::post('/banner', [BannerController::class, 'store'])
->middleware('permission:create_sliders')
->name('employee.banner.store');

Route::get('/banner/{id}', [BannerController::class, 'show'])
->middleware('permission:view_sliders')
->name('employee.banner.show');

Route::get('/banner/{id}/edit', [BannerController::class, 'edit'])
->middleware('permission:edit_sliders')
->name('employee.banner.edit');

Route::put('/banner/{id}', [BannerController::class, 'update'])
->middleware('permission:edit_sliders')
->name('employee.banner.update');

Route::delete('/banner/{id}', [BannerController::class, 'destroy'])
->middleware('permission:delete_sliders')
->name('employee.banner.destroy');

    // ================= MEDSPA GIFT =================
    Route::resource('/medspa-gift', MedsapGiftController::class)
        ->names('employee.medspa-gift')
        ->middleware('permission:view_medspa_gift');

 

    // ================= GIFT =================
    Route::resource('/gift', GiftController::class)
        ->names('employee.gift')
        ->middleware('permission:view_gift');


    // ================= GIFTCARD =================
    Route::get('/giftcards-orders', [GiftsendController::class, 'cardgeneratedList'])
    ->name('employee.giftcards-orders')
    ->middleware('permission:view_giftcard_orders');

        Route::get('/gift-card-transaction-search', [GiftsendController::class, 'GifttransactionSearch'])
        ->name('employee.gift-card-transaction-search')
        ->middleware('permission:view_giftcard_orders');

        Route::get('/giftcardredeem-view', [GiftsendController::class, 'giftcardredeemView'])
        ->name('employee.giftcardredeem-view')
        ->middleware('permission:view_giftcard_redeem');

        Route::get('/giftcardredeem-from-patientlist/{id}', [GiftsendController::class, 'giftcardredeemPatientList'])
        ->name('employee.giftcardredeemPatientList')
        ->middleware('permission:view_giftcard_redeem');

        Route::get('/redeem-giftcard/{transaction_id}/{user_id}', [GiftsendController::class, 'RedeemGiftcard'])
        ->name('employee.redeem-giftcard')
        ->middleware('permission:view_giftcard_redeem');

        Route::get('/giftcardsearch', [GiftsendController::class, 'GiftCardSearch'])
        ->name('employee.giftcard-search')
        ->middleware('permission:view_giftcard_redeem');

        Route::post('/giftcardredeem', [GiftsendController::class, 'giftcardredeem'])
        ->name('employee.giftcardredeem')
        ->middleware('permission:create_giftcard_redeem');

        Route::post('/giftcardstatment', [GiftsendController::class, 'giftcardstatment'])
        ->name('employee.giftcardstatment')
        ->middleware('permission:view_giftcard_redeem');

        Route::get('/giftcards-sale/{id?}', [GiftsendController::class, 'giftsale'])
        ->name('employee.giftcards-sale')
        ->middleware('permission:view_giftcard_redeem');

        Route::post('/giftcancel', [GiftsendController::class, 'giftcancel'])
        ->name('employee.giftcancel')
        ->middleware('permission:delete_giftcard_redeem');
    

    

    // ================= PROGRAM =================
Route::get('/program', [ProgramController::class, 'index'])
->middleware('permission:view_programs')
->name('employee.program.index');

Route::get('/program/create', [ProgramController::class, 'create'])
->middleware('permission:create_programs')
->name('employee.program.create');

Route::post('/program', [ProgramController::class, 'store'])
->middleware('permission:create_programs')
->name('employee.program.store');

Route::get('/program/{id}', [ProgramController::class, 'show'])
->middleware('permission:view_programs')
->name('employee.program.show');

Route::get('/program/{id}/edit', [ProgramController::class, 'edit'])
->middleware('permission:edit_programs')
->name('employee.program.edit');

Route::put('/program/{id}', [ProgramController::class, 'update'])
->middleware('permission:edit_programs')
->name('employee.program.update');

Route::delete('/program/{id}', [ProgramController::class, 'destroy'])
->middleware('permission:delete_programs')
->name('employee.program.destroy');

    // ================= PATIENT =================
Route::get('/patient', [PatientController::class, 'index'])
->middleware('permission:view_patients')
->name('employee.patient.index');

Route::get('/patient/table-data', [PatientController::class, 'patientTableData'])
->middleware('permission:view_patients')
->name('employee.patient.table.data');

Route::post('/patient-quick-create', [PatientController::class, 'PatientQuickCreate'])
->middleware('permission:create_patients')
->name('employee.patient-quick-create');


Route::get('/patient/create', [PatientController::class, 'create'])
->middleware('permission:create_patients')
->name('employee.patient.create');

Route::post('/patient', [PatientController::class, 'store'])
->middleware('permission:create_patients')
->name('employee.patient.store');

Route::get('/patient/{id}', [PatientController::class, 'show'])
->middleware('permission:view_patients')
->name('employee.patient.show');

Route::get('/patient/{id}/edit', [PatientController::class, 'edit'])
->middleware('permission:edit_patients')
->name('employee.patient.edit');

Route::put('/patient/{id}', [PatientController::class, 'update'])
->middleware('permission:edit_patients')
->name('employee.patient.update');

Route::delete('/patient/{id}', [PatientController::class, 'destroy'])
->middleware('permission:delete_patients')
->name('employee.patient.destroy');

    // ================= EMPLOYEES =================
    Route::get('/employees', [EmployeeController::class, 'index'])
->middleware('permission:view_employees')
->name('employee.employees.index');

Route::get('/employees/create', [EmployeeController::class, 'create'])
->middleware('permission:create_employees')
->name('employee.employees.create');

Route::post('/employees', [EmployeeController::class, 'store'])
->middleware('permission:create_employees')
->name('employee.employees.store');

Route::get('/employees/{id}', [EmployeeController::class, 'show'])
->middleware('permission:view_employees')
->name('employee.employees.show');

Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])
->middleware('permission:edit_employees')
->name('employee.employees.edit');

Route::put('/employees/{id}', [EmployeeController::class, 'update'])
->middleware('permission:edit_employees')
->name('employee.employees.update');

Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])
->middleware('permission:delete_employees')
->name('employee.employees.destroy');

    // ================= DESIGNATIONS =================
    Route::get('/designations', [DesignationController::class, 'index'])
->middleware('permission:view_designations')
->name('employee.designations.index');

Route::get('/designations/create', [DesignationController::class, 'create'])
->middleware('permission:create_designations')
->name('employee.designations.create');

Route::post('/designations', [DesignationController::class, 'store'])
->middleware('permission:create_designations')
->name('employee.designations.store');

Route::get('/designations/{id}', [DesignationController::class, 'show'])
->middleware('permission:view_designations')
->name('employee.designations.show');

Route::get('/designations/{id}/edit', [DesignationController::class, 'edit'])
->middleware('permission:edit_designations')
->name('employee.designations.edit');

Route::put('/designations/{id}', [DesignationController::class, 'update'])
->middleware('permission:edit_designations')
->name('employee.designations.update');

Route::delete('/designations/{id}', [DesignationController::class, 'destroy'])
->middleware('permission:delete_designations')
->name('employee.designations.destroy');

    // ================= ACCESS CONTROL =================
 Route::get('/access-controls', [AccessControlController::class, 'index'])
->middleware('permission:view_access_control')
->name('employee.access-control.index');

Route::get('/access-controls/create', [AccessControlController::class, 'create'])
->middleware('permission:create_access_control')
->name('employee.access-control.create');

Route::post('/access-controls', [AccessControlController::class, 'store'])
->middleware('permission:create_access_control')
->name('employee.access-control.store');

Route::get('/access-controls/{id}', [AccessControlController::class, 'show'])
->middleware('permission:view_access_control')
->name('employee.access-control.show');

Route::get('/access-controls/{id}/edit', [AccessControlController::class, 'edit'])
->middleware('permission:edit_access_control')
->name('employee.access-control.edit');

Route::put('/access-controls/{id}', [AccessControlController::class, 'update'])
->middleware('permission:edit_access_control')
->name('employee.access-control.update');

Route::delete('/access-controls/{id}', [AccessControlController::class, 'destroy'])
->middleware('permission:delete_access_control')
->name('employee.access-control.destroy');

    // ================= DEPARTMENTS =================
  Route::get('/departments', [DepartmentController::class, 'index'])
->middleware('permission:view_departments')
->name('employee.departments.index');

Route::get('/departments/create', [DepartmentController::class, 'create'])
->middleware('permission:create_departments')
->name('employee.departments.create');

Route::post('/departments', [DepartmentController::class, 'store'])
->middleware('permission:create_departments')
->name('employee.departments.store');

Route::get('/departments/{id}', [DepartmentController::class, 'show'])
->middleware('permission:view_departments')
->name('employee.departments.show');

Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])
->middleware('permission:edit_departments')
->name('employee.departments.edit');

Route::put('/departments/{id}', [DepartmentController::class, 'update'])
->middleware('permission:edit_departments')
->name('employee.departments.update');

Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])
->middleware('permission:delete_departments')
->name('employee.departments.destroy');

    // ================= CLINICS =================

  Route::get('/clinics', [ClinicController::class, 'index'])
->middleware('permission:view_clinics')
->name('employee.clinics.index');

Route::get('/clinics/create', [ClinicController::class, 'create'])
->middleware('permission:create_clinics')
->name('employee.clinics.create');

Route::post('/clinics', [ClinicController::class, 'store'])
->middleware('permission:create_clinics')
->name('employee.clinics.store');

Route::get('/clinics/{id}', [ClinicController::class, 'show'])
->middleware('permission:view_clinics')
->name('employee.clinics.show');

Route::get('/clinics/{id}/edit', [ClinicController::class, 'edit'])
->middleware('permission:edit_clinics')
->name('employee.clinics.edit');

Route::put('/clinics/{id}', [ClinicController::class, 'update'])
->middleware('permission:edit_clinics')
->name('employee.clinics.update');

Route::delete('/clinics/{id}', [ClinicController::class, 'destroy'])
->middleware('permission:delete_clinics')
->name('employee.clinics.destroy');


    // ================= POPULAR OFFERS =================
         
  Route::get('/popular-offers', [PopularOfferController::class, 'index'])
->middleware('permission:view_popular_offers')
->name('employee.popular-offers.index');

Route::get('/popular-offers/create', [PopularOfferController::class, 'create'])
->middleware('permission:create_popular_offers')
->name('employee.popular-offers.create');

Route::post('/popular-offers', [PopularOfferController::class, 'store'])
->middleware('permission:create_popular_offers')
->name('employee.popular-offers.store');

Route::get('/popular-offers/{id}', [PopularOfferController::class, 'show'])
->middleware('permission:view_popular_offers')
->name('employee.popular-offers.show');

Route::get('/popular-offers/{id}/edit', [PopularOfferController::class, 'edit'])
->middleware('permission:edit_popular_offers')
->name('employee.popular-offers.edit');

Route::put('/popular-offers/{id}', [PopularOfferController::class, 'update'])
->middleware('permission:edit_popular_offers')
->name('employee.popular-offers.update');

Route::delete('/popular-offers/{id}', [PopularOfferController::class, 'destroy'])
->middleware('permission:delete_popular_offers')
->name('employee.popular-offers.destroy');

});