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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/add-question', [App\Http\Controllers\QuestionController::class, 'addQuestion'])->name('addQuestion')->middleware('auth');
Route::post('/store-question', [App\Http\Controllers\QuestionController::class, 'storeQuestion'])->name('storeQuestion')->middleware('auth');

Route::get('/index', [App\Http\Controllers\QuestionController::class, 'index'])->name('index')->middleware('auth');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');

