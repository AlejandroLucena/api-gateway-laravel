<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\v1\Posts\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/v1/posts', 'controller' => PostController::class], function () {
    Route::get('/health', [ApiController::class, 'health'])->name('health');
    Route::get('/', 'get');
    Route::get('/{id}', 'find');
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
