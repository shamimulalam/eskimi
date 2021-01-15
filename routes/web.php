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

Route::get('/',['App\Http\Controllers\HomeController','index']);
Route::get('/campaign/index',['App\Http\Controllers\CampaignController','index']);
Route::post('/campaign/store',['App\Http\Controllers\CampaignController','store']);
Route::get('/campaign/{id}',['App\Http\Controllers\CampaignController','show']);
Route::put('/campaign/{id}',['App\Http\Controllers\CampaignController','update']);
Route::any('/{segment1}/{segment2?}/{segment3?}',['App\Http\Controllers\HomeController','index']);
