<?php

use App\Http\Controllers\Api\TestEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('send-email', [TestEmailController::class, 'sendEmail']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
