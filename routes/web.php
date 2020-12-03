<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\WordsController;

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


Route::group(['prefix'=>'api'], function () {
    Route::get('/words/record', [WordsController::class, 'index']);
    Route::get('/words/list', [WordsController::class, 'list']);
    Route::get('/words/del', [WordsController::class, 'del']);
});
