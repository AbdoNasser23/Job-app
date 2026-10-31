<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home.index');
})->name('home');


Route::middleware(['auth','role:job_seeker'])->group(function () {
    Route::get('dashboard',DashboardController::class)->name('dashboard');
    Route::get('vacancy/{vacancy}',[VacancyController::class,'show'])->name('vacancy.show');
    Route::get('vacancy/{vacancy}/apply',[VacancyController::class,'apply'])->name('vacancy.apply');
    Route::post('vacancy/{vacancy}/apply',[VacancyController::class,'processToApply'])->name('vacancy.processToApply');
    Route::get('application',[ApplicationController::class,'index'])->name('application.index');







});

require __DIR__.'/auth.php';
