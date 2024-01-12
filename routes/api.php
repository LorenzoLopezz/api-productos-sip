<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\api\ProductoController;
use App\Http\Controllers\api\VentasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('jwt.auth')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('jwt.auth')->post('/refresh', [AuthController::class, 'refresh']);
    Route::middleware('jwt.auth')->post('/me', [AuthController::class, 'me']);
});

Route::prefix('/user')->group(function () {
    Route::middleware('jwt.auth')->get('/', [UserController::class, 'index']);
    Route::middleware(['jwt.auth', 'role:SUPER_ADMIN'])->post('/', [UserController::class, 'store']);
    Route::middleware(['jwt.auth', 'permission:PERMISSION_USER_SHOW'])->get('/{id}', [UserController::class, 'show']);
    Route::middleware(['jwt.auth', 'permission:PERMISSION_USER_UPDATE'])->put('/{id}', [UserController::class, 'update']);
    Route::middleware(['jwt.auth', 'permission:PERMISSION_USER_DELETE'])->delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('/producto')->group(function () {
    Route::middleware(['jwt.auth', 'permission:PERMISSION_LISTAR_PRODUCTOS'])->get('/', [ProductoController::class, 'index']);
    Route::middleware(['jwt.auth', 'role:SUPER_ADMIN'])->post('/', [ProductoController::class, 'create']);
    Route::middleware(['jwt.auth', 'role:SUPER_ADMIN'])->put('/{id}', [ProductoController::class, 'update']);
    Route::middleware(['jwt.auth', 'role:SUPER_ADMIN'])->delete('/{id}', [ProductoController::class, 'update']);
});

Route::prefix('/ventas')->group(function () {
    Route::middleware(['jwt.auth', 'permission:PERMISSION_LISTAR_PRODUCTOS'])->get('/', [VentasController::class, 'index']);
    Route::middleware(['jwt.auth', 'permission:PERMISSION_LISTAR_PRODUCTOS'])->post('/', [VentasController::class, 'store']);
});
