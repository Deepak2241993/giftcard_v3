<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;


// For All Patient Route
Route::prefix('My-patient')->middleware('auth:patient')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'PatientDashboard'])->name('patient-dashboard');
    Route::get('/patient-profile', [PatientController::class, 'PatientProfile'])->name('patient-profile');
    Route::get('/my-giftcards', [PatientController::class, 'Mygiftcards'])->name('my-giftcards');
    Route::get('/giftcards-statement/{id}', [PatientController::class, 'GiftcardsStatement'])->name('giftcards-statement');
    Route::get('/my-services', [PatientController::class, 'Myservices'])->name('my-services');
    Route::get('/patient-invoice/{transaction_data}', [PatientController::class, 'Patientinvoice'])->name('patient-invoice');
});