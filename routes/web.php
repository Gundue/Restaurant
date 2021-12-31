<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryListController;
use App\Http\Controllers\InsertController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard/{category}', [CategoryListController::class, 'List']);
Route::get('/insert', [InsertController::class, 'index']);
Route::post('/insert', [InsertController::class, 'upload']);