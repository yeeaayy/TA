<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\MqttUserController;
use App\Http\Controllers\SensorDataController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('welcome');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
Route::get('/sensor', function () {return view('sensor');})->name('sensor');
Route::get('/download-arduino', function () {
    $filePath = public_path('arduino/tamplate.ino');
    return Response::download($filePath, 'arduino-template.ino');})->name('download.arduino');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/sensor-data', [SensorDataController::class, 'index']);
Route::get('/api/sensor-data', [SensorDataController::class, 'index']);
Route::get('/mqtt/data', function () {
    $data = DB::table('sensor_data')->get();
    return view('mqtt.data', compact('data'));
})->name('mqtt.data');





Route::get('/sensor-data/{topic}', [SensorController::class, 'getSensorData']);
Route::get('/sensor-dashboard/{topic}', function ($topic) {
    return view('sensor-data', ['topic' => $topic]);
})->name('mqtt.show');
Route::get('/mqtt/{id}', [MqttUserController::class, 'show'])->name('mqtt.show');
Route::get('/rules/create', function () {
    return view('rules');
});
Route::post('/rules', [RulesController::class, 'createRule']);
Route::get('/rules', [RulesController::class, 'getRules']);
Route::delete('/rules/{id}', [RulesController::class, 'deleteRule']);
Route::get('/mqtt', [MqttUserController::class, 'index'])->name('mqtt.index');
Route::post('/mqtt/store', [MqttUserController::class, 'store'])->name('user.create');
Route::delete('/mqtt/delete', [MqttUserController::class, 'destroy'])->name('user.delete');
});
