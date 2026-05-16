<?php
use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.api.key')->prefix('v1')->group(function () {
    Route::get('/components', [ComponentController::class, 'index']);
    Route::get('/components/{id}', [ComponentController::class, 'show']);
    Route::post('/components/receive', [ComponentController::class, 'receive']);
});