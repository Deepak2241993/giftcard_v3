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


//    For Giftcard Order History
        Route::get('/giftcards-orders', [GiftsendController::class, 'cardgeneratedList'])
            ->middleware('permission:view_giftcard_orders')
            ->name('employee.giftcards-orders');



//     For Service Order History
        Route::middleware('permission:view_service_orders')->group(function () {
                Route::get('/service-orders', [TransactionHistoryController::class, 'index'])
                    ->name('employee.service-orders.index');

                });

// ================= CATEGORY =================
Route::get('/category', [ProductCategoryController::class, 'index'])
->middleware('permission:view_category')
->name('employee.category.index');

Route::get('/category/create', [ProductCategoryController::class, 'create'])
->middleware('permission:add_category')
->name('employee.category.create');

Route::post('/category', [ProductCategoryController::class, 'store'])
->middleware('permission:add_category')
->name('employee.category.store');

Route::get('/category/{id}/edit', [ProductCategoryController::class, 'edit'])
->middleware('permission:edit_category')
->name('employee.category.edit');

Route::put('/category/{id}', [ProductCategoryController::class, 'update'])
->middleware('permission:edit_category')
->name('employee.category.update');

Route::delete('/category/{id}', [ProductCategoryController::class, 'destroy'])
->middleware('permission:delete_category')
->name('employee.category.destroy');

  // ================= UNIT =================
Route::get('/unit', [ServiceUnitController::class, 'index'])
->middleware('permission:view_units')
->name('employee.unit.index');

Route::get('/unit/create', [ServiceUnitController::class, 'create'])
->middleware('permission:add_units')
->name('employee.unit.create');

Route::post('/unit', [ServiceUnitController::class, 'store'])
->middleware('permission:add_units')
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

// ================= PRODUCT =================
Route::get('/product', [ProductController::class, 'index'])
->middleware('permission:view_product')
->name('employee.product.index');

Route::get('/product/create', [ProductController::class, 'create'])
->middleware('permission:add_product')
->name('employee.product.create');

Route::post('/product', [ProductController::class, 'store'])
->middleware('permission:add_product')
->name('employee.product.store');

Route::get('/product/{id}', [ProductController::class, 'show'])
->middleware('permission:view_product')
->name('employee.product.show');

Route::get('/product/{id}/edit', [ProductController::class, 'edit'])
->middleware('permission:edit_product')
->name('employee.product.edit');

Route::put('/product/{id}', [ProductController::class, 'update'])
->middleware('permission:edit_product')
->name('employee.product.update');

Route::delete('/product/{id}', [ProductController::class, 'destroy'])
->middleware('permission:delete_product')
->name('employee.product.destroy');

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
->middleware('permission:view_static_content')
->name('employee.static-content.index');

Route::get('/static-content/create', [StaticContentController::class, 'create'])
->middleware('permission:create_static_content')
->name('employee.static-content.create');

Route::post('/static-content', [StaticContentController::class, 'store'])
->middleware('permission:create_static_content')
->name('employee.static-content.store');

Route::get('/static-content/{id}', [StaticContentController::class, 'show'])
->middleware('permission:view_static_content')
->name('employee.static-content.show');

Route::get('/static-content/{id}/edit', [StaticContentController::class, 'edit'])
->middleware('permission:edit_static_content')
->name('employee.static-content.edit');

Route::put('/static-content/{id}', [StaticContentController::class, 'update'])
->middleware('permission:edit_static_content')
->name('employee.static-content.update');

Route::delete('/static-content/{id}', [StaticContentController::class, 'destroy'])
->middleware('permission:delete_static_content')
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

   // ================= EMAIL TEMPLATE =================
    Route::resource('/email-template', EmailTemplateController::class)
        ->names('employee.email-template')
        ->middleware('permission:view_email_template');

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
        ->middleware('permission:view_giftcard_orders')
        ->name('employee.giftcards-orders');

    Route::get('/giftcardsearch', [GiftsendController::class, 'GiftCardSearch'])
        ->middleware('permission:view_giftcard_orders')
        ->name('employee.giftcard-search');

  

    // ================= BANNER =================
    Route::resource('/banner', BannerController::class)
        ->names('employee.banner')
        ->middleware('permission:view_banner');

    

    // ================= PROGRAM =================
    Route::resource('/program', ProgramController::class)
        ->names('employee.program')
        ->middleware('permission:view_program');

    // ================= PRODUCT =================
    Route::resource('/product', ProductController::class)
        ->names('employee.product')
        ->middleware('permission:view_product');

    // ================= PATIENT =================
    Route::resource('/patient', PatientController::class)
        ->names('employee.patient')
        ->middleware('permission:view_patient');

    // ================= EMPLOYEES =================
    Route::resource('/employees', EmployeeController::class)
        ->names('employee.employees')
        ->middleware('permission:view_employees');

    // ================= DESIGNATIONS =================
    Route::resource('/designations', DesignationController::class)
        ->names('employee.designations')
        ->middleware('permission:view_designations');

    // ================= ACCESS CONTROL =================
    Route::resource('/access-control', AccessControlController::class)
        ->names('employee.access-control')
        ->middleware('permission:view_access_control');

    // ================= DEPARTMENTS =================
    Route::resource('/departments', DepartmentController::class)
        ->names('employee.departments')
        ->middleware('permission:view_departments');

    // ================= CLINICS =================
    Route::resource('/clinics', ClinicController::class)
        ->names('employee.clinics')
        ->middleware('permission:view_clinics');

    // ================= POPULAR OFFERS =================
    Route::resource('/popular-offers', PopularOfferController::class)
        ->names('employee.popular-offers')
        ->middleware('permission:view_popular_offers');

});