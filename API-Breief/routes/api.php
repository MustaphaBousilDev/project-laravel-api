<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanteController;
use App\Http\Controllers\CategoryController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('updateProfile', 'updateProfile');
    Route::post('resetPassword', 'resetPassword');
});

Route::post('password-reset/{token}',[AuthController::class, 'updatePassword']);
Route::apiResource('plants', PlanteController::class);
//delete plante 
Route::delete('plantss/{plante}',[PlanteController::class, 'destroy']);
//iupdate 
Route::put('plantss/{plante}',[PlanteController::class, 'update']);
Route::apiResource('categories', CategoryController::class);


//route change role 
Route::put('changeRole/{user}',[AuthController::class, 'changeRole']);


