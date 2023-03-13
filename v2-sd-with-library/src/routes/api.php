<?php

use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HealthCheckController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OrganizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', HealthCheckController::class);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [UserController::class, 'getUserLogged']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/create/organization', [OrganizationController::class, 'store']);
    Route::middleware(['tenant', 'user_schema'])->group(function () {
        Route::get('/article', [ArticleController::class, 'index']);
    });

    Route::get('create/database', function () {
        DB::statement('CREATE DATABASE IF NOT EXISTS coba');
    });
});
