<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    ReviewController,
    };

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


   // Clients Reviews
   Route::resource('/client-reviews', ReviewController::class)->except(['show']);
   Route::get('/clients/reviews/{id}/{status}', [ReviewController::class , 'clientreviews_status'])->name('clientreviews_status');
