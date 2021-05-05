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

Route::get('/.well-known/pki-validation/0F524100EDED49375D9C4C5F8D895088.txt', function() {
    return response('B790F0643144CB72C43648EEAE6AAA0F3D3F0FEDDA53660DEA1A08010F327D7A comodoca.com 606e9371a3a80', 200)
        -> header('Content-Type', 'text/plain');
});

Route::get('info', function() { phpinfo();});
