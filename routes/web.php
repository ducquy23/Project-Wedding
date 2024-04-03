<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    // Auth route
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('admin.loginPost');

    // Admin route
//    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
//    });
});

