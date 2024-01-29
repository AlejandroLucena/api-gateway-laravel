<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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

$router->get('/posts', [PostController::class, 'index'])->name('posts.index');
$router->get('/posts/{id}', [PostController::class, 'find'])->name('posts.find');
$router->post('/posts', [PostController::class, 'store'])->name('posts.store');
$router->patch('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
$router->delete('/posts/{id}', [PostController::class, 'delete'])->name('posts.delete');
