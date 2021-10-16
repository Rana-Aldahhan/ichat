<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {  return view('welcome');});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::put('/edit-profile',[UserController::class ,'update'] )->middleware('auth');
Route::get('/contacts', [ContactsController::class,'index'])->middleware('auth');
Route::post('/add-contact',[ContactsController::class,'addContact'])->middleware('auth');
Route::get('/users/{id}/chat',[MessageController::class,'index'])->middleware('auth');
Route::post('/users/{id}/chat',[MessageController::class,'store'])->middleware('auth');
Auth::routes();

