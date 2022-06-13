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
    return view('welcome');
});

Route::get('/clear_cache', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    //Artisan::call('route:cache');
   return "Cache is cleared";
});

Route::get('/admin',[App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');


Route::get('logout',[App\Http\Controllers\Admin\AuthController::class, 'logout']);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');

Route::view('/dashboard','admin.index');

$admin_path ='admin';

Route::group(['middleware' => ['is_admin']],function(){

Route::resource('permissions', 'CompanyController');

            });

include_once(base_path().'/routes/admin/admin.php');            
