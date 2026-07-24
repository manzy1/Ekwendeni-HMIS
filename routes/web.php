<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\FamilyPlanningVisitController;
use App\Http\Controllers\OpdVisitController;
use App\Http\Controllers\WardAdmissionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/patients');
Route::resource('patients', PatientController::class)->only(['index', 'create', 'store']);
Route::resource('family-planning-visits', FamilyPlanningVisitController::class)->only(['index', 'create', 'store']);
Route::get('family-planning/annual-report', [FamilyPlanningVisitController::class, 'annualReport'])->name('family-planning.annual-report');
Route::resource('opd-visits', OpdVisitController::class)->only(['index', 'create', 'store']);
Route::resource('ward-admissions', WardAdmissionController::class)->only(['index', 'create', 'store']);
