<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Tags
Route::apiResource('tags',TagController::class);

// Categories
Route::apiResource('categories',CategoryController::class);

// Ads
Route::prefix('ads')->group(function () {
    Route::get('show_by_advertiser', [AdController::class, 'show_by_advertiser']);
    Route::get('filter_by_category', [AdController::class, 'filter_by_category']);
    Route::get('filter_by_tag', [AdController::class, 'filter_by_tag']);
});

Route::apiResource('ads',AdController::class);


