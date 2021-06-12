<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\BusStop;
use App\Http\Controllers\QuoteApiController;

// Route::get('info', function() { phpinfo();});

Route::get('/gym_planner/login', [DatabaseController::class, 'login']);
Route::get('/gym_planner/signup', [DatabaseController::class, 'signup']);
Route::get('/gym_planner/get_user_exercise', [DatabaseController::class, 'get_user_exercise']);
Route::get('/gym_planner/get_user_exercise_data', [DatabaseController::class, 'get_user_exercise_data']);
Route::get('/gym_planner/get_all_future_exercise_data', [DatabaseController::class, 'get_all_future_exercise_data']);
Route::post('/gym_planner/add_edit_exercise_data', [DatabaseController::class, 'add_edit_exercise_data']);
Route::get('/gym_planner/add_new_exercise', [DatabaseController::class, 'add_new_exercise']);
Route::get('/gym_planner/delete_exercise_data', [DatabaseController::class, 'delete_exercise_data']);
Route::get('/gym_planner/new_set_done', [DatabaseController::class, 'new_set_done']);

Route::get('/api/get_nearest_bus_stop', [BusStop::class, 'get_nearest_bus_stop']);
Route::get('/api/get_bus_arrival_timing', [BusStop::class, 'get_bus_arrival_timing']);
Route::get('/api/get_bus_route', [BusStop::class, 'get_bus_route']);
Route::get('/api/get_bus_data', [BusStop::class, 'search_bus']);
Route::get('/api/get_bus_stop_data', [BusStop::class, 'get_bus_stop']);
Route::get('/api/get_quote', [QuoteApiController::class, 'get_quote']);

Route::get('/api/login', [UserController::class, 'login']);
Route::post('/api/signup', [UserController::class, 'signup']);
Route::get('/api/signup_confirmation', [UserController::class, 'signup_confirmation']);
Route::get('/api/signout', [UserController::class, 'signout']);
Route::post('/api/update_password', [UserController::class, 'update_password']);
Route::post('/api/generate_code', [UserController::class, 'generate_code']);
Route::post('/api/confirm_pin', [UserController::class, 'confirm_pin']);
Route::post('/api/update_user_cred', [UserController::class, 'update_user_cred']);

Route::get('/api/dashboard/data_by_day', [UserController::class, 'get_user_api_calls_by_day']);
Route::get('/api/dashboard/data_by_ip_address', [UserController::class, 'get_user_api_calls_by_ip_address']);
Route::get('/api/dashboard', [UserController::class, 'dashboard']);
Route::get('/api/dashboard/auth', function() {
    return view('api.input');
});
Route::get('/api/dashboard/forget_password', function() {
    return view('api.forget_password');
});

Route::post('/api/education', [UserController::class, 'website']);
Route::get('/api/education/list_of_api', function() {
    return view('api.list_of_api');
});
Route::get('/api/education/documentations', function() {
    return view('api.documentations');
});
Route::get('/api/education/FAQs', function() {
    return view('api.faqs');
});

Route::get('/', function () {
    return view('portfolio.index');
});
Route::get('/apps', function() {
    return view('portfolio.apps');
});
Route::post('/email', [MailController::class, 'sendEmail']);

Route::get('/.well-known/pki-validation/0F524100EDED49375D9C4C5F8D895088.txt', function() {
    return response('B790F0643144CB72C43648EEAE6AAA0F3D3F0FEDDA53660DEA1A08010F327D7A comodoca.com 606e9371a3a80', 200)
        -> header('Content-Type', 'text/plain');
});