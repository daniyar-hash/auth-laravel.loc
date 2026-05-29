<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store'])->name('user.store');
Route::get('login', [UserController::class, 'login'])->name('login');


Route::get('email-verify', function () {
    return view('user.email-verify');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:3,1'])->name('verification.send');