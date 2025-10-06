<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Actions\Logout;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('register', Register::class)
        ->name('register');

    // Route::post('login', function () {
        
    //     Login::login([
    //         'email' => request('email|string|email'),
    //         'password' => request('password|string'),
    //         'remember' => request()->has('remember|boolean'),
    //     ]);
    //     return redirect()->intended(route('dashboard'));
    //     // return redirect()->route('dashboard');
    // });

    // Route::post('register', [Register::class,
    //     'register']);
});

Route::post('logout', Logout::class)
    ->name('logout');
