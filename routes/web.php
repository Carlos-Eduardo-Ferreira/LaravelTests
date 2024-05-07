<?php

use Illuminate\Support\Facades\Route;

// welcome route - start
Route::get('/', function () {
    return view('welcome');
})->
name('welcome');
// welcome route - end

// dashboard route - start
Route::get('/dashboard', function () {
    return view('dashboard');
})->
middleware(['auth', 'verified'])->
name('dashboard');
// dashboard route - end

// routes middleware guest - start
Route::middleware('guest')->group(function () {
    Route::get('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register.create');
    Route::post('register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('forgot_password.create');
    Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('forgot_password.store');

    Route::get('reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('reset_password.create');
    Route::post('reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('reset_password.store');
});
// routes middleware guest - end

// routes middleware auth - start
Route::middleware('auth')->group(function () {
    Route::get('verify-email', App\Http\Controllers\Auth\EmailVerificationPromptController::class)->name('verify_email.notice');
    Route::get('verify-email/{id}/{hash}', App\Http\Controllers\Auth\VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verify_email.verify');
    
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('email/verification-notification', [App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('email.verification-notification.store');

    Route::get('confirm-password', [App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'show'])->name('confirm_password.show');
    Route::post('confirm-password', [App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'store'])->name('confirm_password.store');;

    Route::put('password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout.destroy');
});
// routes middleware auth - end
