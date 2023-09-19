<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

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

// Route::prefix('cms/admin')->middleware('guest:admin')->group(function () {
//     Route::get('login', [AuthController::class, 'showLogin'])->name('cms.login');
//     Route::post('login', [AuthController::class, 'login']);
// });
Route::get('/', function () {
    return view('welcome');
});
//->middleware('auth:admin')
Route::prefix('cms/admin')->group(function () {
    Route::view('/', 'cms.temp');
    Route::resource('cities', CityController::class);
    Route::resource('admins', AdminController::class);
});

Route::get('news', function () {
    echo "This is the new Title!";
})->middleware('age.check:17');
//
