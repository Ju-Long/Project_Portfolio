<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Mail\Contact;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\BusStop;
use App\Http\Controllers\QuoteApiController;

Route::get('/test', function (Request $req) {
    date_default_timezone_set("Singapore");
    $curr = time();
    return date('Y-m-d', $curr);
});

// Route::get('info', function() { phpinfo();});

Route::get('/gym_planner/login', [DatabaseController::class, 'login']);
Route::get('/gym_planner/signup', [DatabaseController::class, 'signup']);
Route::get('/gym_planner/get_user_exercise', [DatabaseController::class, 'get_user_exercise']);
Route::get('/gym_planner/get_user_exercise_data', [DatabaseController::class, 'get_user_exercise_data']);
Route::get('/gym_planner/add_edit_exercise_data', [DatabaseController::class, 'add_edit_exercise_data']);
Route::get('/gym_planner/add_new_exercise', [DatabaseController::class, 'add_new_exercise']);
Route::get('/gym_planner/delete_exercise_data', [DatabaseController::class, 'delete_exercise_data']);
Route::get('/gym_planner/new_set_done', [DatabaseController::class, 'new_set_done']);

Route::get('/api/get_nearest_bus_stop', [BusStop::class, 'get_nearest_bus_stop']);
Route::get('/api/get_bus_arrival_timing', [BusStop::class, 'get_bus_arrival_timing']);
Route::get('/api/get_bus_route', [BusStop::class, 'get_bus_route']);
Route::get('/api/get_bus_data', [BusStop::class, 'search_bus']);
Route::get('/api/get_bus_stop_data', [BusStop::class, 'get_bus_stop']);
Route::get('/api/get_quote', [QuoteApiController::class, 'get_quote']);

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