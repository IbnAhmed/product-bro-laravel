<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
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

Route::middleware(['api'])->group(function () {
    Route::name('api.')->group(function (){
        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/register', [AuthController::class, 'register']);
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
        });

        Route::middleware(['auth:api'])->group(function () {
            Route::prefix('auth')->group(function () {
                Route::post('/logout', [AuthController::class, 'logout']);
                Route::post('/refresh', [AuthController::class, 'refresh']);
                Route::get('/user-profile', [AuthController::class, 'userProfile']);    
            });
            Route::prefix('products')->group(function () {
                Route::post('/', [ProductController::class, 'store'])->name('products.store');
                Route::post('/{product}', [ProductController::class, 'update'])->name('products.update');
                Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            });
        });
    });
});