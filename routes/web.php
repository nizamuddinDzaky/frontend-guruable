<?php

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
    return redirect()->route('loginPage');
})->name('/');

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');

Route::group(['middleware' => ['web', 'custom_auth']], function () {
    Route::get('/wkwkPage', [App\Http\Controllers\AuthController::class, 'wkwkPage'])->name('wkwkPage');
    Route::get('/home-page', [App\Http\Controllers\HomeController::class, 'index'])->name('homePage');
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});