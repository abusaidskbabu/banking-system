<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('signup', [LoginController::class, 'signup'])->name('signup');
Route::post('signup/store', [LoginController::class, 'signupProcess'])->name('signup.store');

Route::get('/', function () {
    return view('login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::get('/deposit', [DepositController::class, 'create'])->name('deposit.create');
    Route::post('/deposit', [DepositController::class, 'store'])->name('deposit.store');

    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawal.index');
    Route::get('/withdrawal', [WithdrawalController::class, 'create'])->name('withdrawal.create');
    Route::post('/withdrawal', [WithdrawalController::class, 'store'])->name('withdrawal.store');
});
