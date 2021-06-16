<?php

use App\Http\Controllers\VideoController;
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

// Welcome page
Route::get('/', [VideoController::class, 'welcome']);

// To save
Route::post('/upload', [VideoController::class, 'store']);

// To show
Route::get('video/{video}', [VideoController::class, 'show'])->name('show.video');
