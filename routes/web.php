<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Mail\Contact;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\BusStop;
use App\Http\Controllers\QuoteApiController;

Route::get('/test', function (Request $req) {
   return $req->ip();
});

Route::get('info', function() { phpinfo();});

Route::get('/add_user_has_exercise_data', [DatabaseController::class, 'add_user_has_exercise_data']);
Route::get('/user', [DatabaseController::class, 'user']);
Route::get('/delete_user_has_exercise_data', [DatabaseController::class, 'delete_user_has_exercise_data']);
Route::get('/edit_user_has_exercise_data', [DatabaseController::class, 'edit_user_has_exercise_data']);
Route::get('/new_exercise', [DatabaseController::class, 'new_exercise']);
Route::get('/new_user', [DatabaseController::class, 'new_user']);
Route::get('/user_has_exercise', [DatabaseController::class, 'user_has_exercise']);
Route::get('/user_has_exercise_data', [DatabaseController::class, 'user_has_exercise_data']);
Route::get('/new_set_done', [DatabaseController::class, 'new_set_done']);

Route::get('/api/get_nearest_bus_stop_code', [BusStop::class, 'get_nearest_busstop']);
Route::get('/api/get_bus_arrival_timing', [BusStop::class, 'get_bus_stop_timing']);
Route::get('/api/get_bus_route', [BusStop::class, 'get_bus_route']);
Route::get('/api/get_bus_data', [BusStop::class, 'search_bus']);
Route::get('/api/get_bus_stop_data', [BusStop::class, 'get_bus_stop']);
Route::get('/api/quote-api', [QuoteApiController::class, 'getQuote']);

Route::get('/api/dashboard', function () {
    return view('api/index');
});

Route::get('/.well-known/pki-validation/0F524100EDED49375D9C4C5F8D895088.txt', function() {
    return response('B790F0643144CB72C43648EEAE6AAA0F3D3F0FEDDA53660DEA1A08010F327D7A comodoca.com 606e9371a3a80', 200)
        -> header('Content-Type', 'text/plain');
});

Route::get('/', function () {
    return view('portfolio/index');
});

Route::get('/email', [MailController::class, 'sendEmail']);

Route::get('/apps', function() {
    return view('portfolio/apps');
});
