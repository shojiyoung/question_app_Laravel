<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::get('/index', [TestController::class, 'index']);
    Route::post('/todos', [TestController::class, 'store']);
    Route::patch('/todos/update', [TestController::class, 'update']);
    Route::delete('/todos/delete', [TestController::class, 'destroy']);
    Route::post('/todos/{todo}/comments', [TestController::class, 'comment_store']);
    
});

