<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\MessageController;
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
Route::prefix('teams')->group(function() {
    Route::get('', [TeamController::class, 'index']);
    Route::post('', [TeamController::class, 'store']);
    Route::post('{team}/add-users', [TeamController::class, 'addUsers']);
    Route::get('{team}', [TeamController::class, 'show']);
    Route::put('', [TeamController::class, 'update']);
    Route::delete('{team}', [TeamController::class, 'destroy']);
});
Route::group(['prefix' => '/demands'], function () {
    Route::get('', [DemandController::class, 'index']);
    Route::get('team/{team}', [DemandController::class, 'getByTeam']);
    Route::get('customer/{customer}', [DemandController::class, 'getByCustomer']);
    Route::get('users/{demand}', [DemandController::class, 'getUsersByDemand']);
    Route::post('', [DemandController::class, 'store']);
    Route::get('{demand}', [DemandController::class, 'show']);
    Route::put('', [DemandController::class, 'update']);
    Route::delete('{demand}', [DemandController::class, 'destroy']);
});
Route::group(['prefix' => '/messages'], function () {
    Route::get('', [MessageController::class, 'index']);
    Route::get('task/{task}', [MessageController::class, 'getByTask']);
    Route::post('', [MessageController::class, 'store']);
    Route::get('{demand}', [MessageController::class, 'show']);
    Route::put('', [MessageController::class, 'update']);
    Route::delete('{demand}', [MessageController::class, 'destroy']);
});
Route::group(['prefix' => '/tasks'], function () {
    Route::get('', [TaskController::class, 'index']);
    Route::post('{task}/complete', [TaskController::class, 'complete']);
    Route::post('{task}/request-approval', [TaskController::class, 'requestApproval']);
    Route::post('', [TaskController::class, 'store']);
    Route::get('{task}', [TaskController::class, 'show']);
    Route::put('', [TaskController::class, 'update']);
    Route::delete('{task}', [TaskController::class, 'destroy']);
});
Route::apiResource('/tasks', TaskController::class);
Route::apiResource('/expenses', ExpenseController::class);
Route::prefix('me')->group(function() {
    Route::get('', [MeController::class, 'index']);
    Route::get('all', [MeController::class, 'all']);
    Route::put('', [MeController::class, 'update']);
});
