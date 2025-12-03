<?php
use App\Http\Controllers\dashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PosopnameController;
use Illuminate\Support\Facades\Route;
use App\Models\Posopnamesublocation;
use Illuminate\Support\Facades\Response;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::middleware('jwt.auth')->group(function () {
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware(['role:Bos|Admin'])->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('index', PosopnameController::class);
        Route::get('/check-print', [dashboardController::class, 'checkPrint']);
        Route::get('/location', [dashboardController::class, 'listPrintLocations']);
    });
});
