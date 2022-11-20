<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search/{id}', [SearchController::class, 'index']);
Route::get('/search-by-date', [SearchController::class, 'search_by_date']);
Route::get('/search/view-insert-form', [SearchController::class, 'insert_search_data']);
Route::post('/search/insert', [SearchController::class, 'insert']);