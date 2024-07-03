<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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



Route::middleware('auth')->group(function () {
    Route::view('/', 'welcome')->name('home');
});



// Route::get('/', function () {
// return view('welcome');
// })->name('home');


Route::get('/index',[AuthController::class,'index'])->name('login');

Route::post('/post_login',[AuthController::class,'postLogin'])->name('post-login');

Route::get ('/registration',[AuthController::class,'Registration'])->name('registratioN');

Route::post('/post_registration',[AuthController::class,'postRegistration'])->name('post-registration');