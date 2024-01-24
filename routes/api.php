<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('/companies', CompanyController::class);
Route::apiResource('/customers', CustomerController::class);
Route::apiResource('/teams', TeamController::class);
// Route::apiResource('/demands', DemandController::class);
Route::group(['prefix' => '/demands'], function () {
    Route::get('', [DemandController::class, 'index']);
    Route::get('team/{team}', [DemandController::class, 'getByTeam']);
    Route::post('', [DemandController::class, 'store']);
    Route::get('{demand}', [DemandController::class, 'show']);
    Route::put('', [DemandController::class, 'update']);
    Route::delete('', [DemandController::class, 'destroy']);
});

Route::apiResource('/tasks', TaskController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::prefix('me')->group(function() {
    Route::get('', [MeController::class, 'index']);
    Route::put('', [MeController::class, 'update']);
});
