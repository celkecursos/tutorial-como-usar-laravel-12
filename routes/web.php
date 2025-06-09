<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GenerateUserController;
use App\Http\Controllers\ImportCSVUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

// Tela de login
Route::get('/login', [AuthController::class, 'index'])->name('login');

// Processar os dados do login
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Solicitar link para resetar senha
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Formulário para redefinir a senha com o token
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showRequestForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('/generate-user', [GenerateUserController::class, 'index'])->name('generate-user');

// Grupo de rotas restritas
Route::group(['middleware' => 'auth'], function () {

    Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
    Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');

    Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
    Route::post('/store-user', [UserController::class, 'store'])->name('user.store');

    Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');

    Route::get('/edit-user-password/{user}', [UserController::class, 'editPassword'])->name('user.edit-password');
    Route::put('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('user.update-password');

    Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/generate-pdf-user/{user}', [UserController::class, 'generatePdf'])->name('user.generate-pdf');
    Route::get('/generate-pdf-user', [UserController::class, 'generatePdfUsers'])->name('user.generate-pdf-users');

    Route::get('/generate-csv-user', [UserController::class, 'generateCSVUsers'])->name('user.generate-csv-users');

    Route::post('/import-csv-user', [ImportCSVUserController::class, 'importCSVUsers'])->name('user.import-csv-users');
});
