<?php

use App\Http\Controllers\GoogleDriveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('google/upload', [GoogleDriveController::class, 'uploadFile']);
