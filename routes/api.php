<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

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

// Issue access tokens
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Protected routes
    Route::get('/detail', [AuthController::class, 'detail']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // For departments
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::get('/departments/{token}', [DepartmentController::class, 'show']);
    Route::put('/departments/{token}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{token}', [DepartmentController::class, 'destroy']);

    // For employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{token}', [EmployeeController::class, 'show']);
    Route::put('/employees/{token}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{token}', [EmployeeController::class, 'destroy']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
