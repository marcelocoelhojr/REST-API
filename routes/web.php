<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer;

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

Route::get('marcelo', function () {
    return 'testasd';
});

//Route::post('cliente', 'App\Http\Controllers\Customer@create');

