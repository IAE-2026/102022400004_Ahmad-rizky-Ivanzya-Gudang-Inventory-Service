<?php
use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('iae.key')->group(function () {
    Route::get('/components', [ComponentController::class, 'index']);
    Route::get('/components/{id}', [ComponentController::class, 'show']);
    Route::post('/components', [ComponentController::class, 'receive']);
});