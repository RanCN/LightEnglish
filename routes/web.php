<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\WordsController;
use App\Http\Controllers\Home\DaysController;


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
    // return "hello world";
    // return view('welcome');
    return view('Home.index');
});

Route::get('/list', function() {
    return view('Home.list');
});

Route::group(['prefix'=>'api'], function () {
    Route::get('/words/record', [WordsController::class, 'index']);

    Route::get('/words/list', [WordsController::class, 'list']);
    Route::get('/words/del', [WordsController::class, 'del']);

    //每日列表
    Route::get('/days/list', [DaysController::class, 'list']);
});
