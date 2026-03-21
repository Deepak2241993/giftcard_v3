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

Route::prefix('employee')->middleware(['auth:web','role:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard');

});