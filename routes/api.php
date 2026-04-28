<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// For QR Scanning devices
Route::post('/attendances/scan', [\App\Http\Controllers\Api\QrAttendanceController::class, 'scan']);
