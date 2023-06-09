<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Candidates
Route::middleware('auth:sanctum')->group( function () {
 
    Route::resource('/areas', App\Http\Controllers\AreaController::class);
    Route::resource('/agents', App\Http\Controllers\AgentController::class);
    Route::resource('/loans', App\Http\Controllers\LoanController::class);
    Route::resource('/accounts', App\Http\Controllers\AccountController::class);
    Route::resource('/loan_repayments', App\Http\Controllers\LoanRepaymentController::class);
    Route::get('/loan_repayments/collections/{loan_repayment}', [App\Http\Controllers\LoanRepaymentController::class, 'collections'])->name('loan_repayments.collections');
    Route::post('/loan_repayments/collected/{id}', [App\Http\Controllers\LoanRepaymentController::class, 'collected'])->name('loan_repayments.collected');
    Route::get('/report/loan', [App\Http\Controllers\ReportController::class, 'loan'])->name('report.loan');
    Route::get('/report/edit', [App\Http\Controllers\ReportController::class, 'edit'])->name('report.edit');
    Route::post('/report/edit', [App\Http\Controllers\ReportController::class, 'edit'])->name('report.edit');
    Route::post('/report/loan', [App\Http\Controllers\ReportController::class, 'loan'])->name('report.loan');
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'create'])->name('collections');
    Route::post('/report/report}', [App\Http\Controllers\ReportController::class, 'report'])->name('collections.report');
});


// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');


    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

    Route::get('export/', [UserController::class, 'export'])->name('export');

});

