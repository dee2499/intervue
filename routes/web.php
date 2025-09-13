<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Interview routes
Route::resource('interviews', App\Http\Controllers\InterviewController::class)->middleware('auth');
Route::get('interviews/{id}/take', [App\Http\Controllers\InterviewController::class, 'takeInterview'])->name('interviews.take')->middleware('auth');

// Submission routes
Route::resource('submissions', App\Http\Controllers\SubmissionController::class)->middleware('auth');

// Review routes
Route::resource('reviews', App\Http\Controllers\ReviewController::class)->middleware('auth');
