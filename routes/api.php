<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GateKeeperController;
use App\Http\Controllers\API\InfoMergingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// gatekeeper
Route::post('/gate/login',[GateKeeperController::class,'login'])->name('gate.login');
Route::post('/gate/register',[GateKeeperController::class,'register'])->name('gate.register');
Route::get('/gete/all', [GateKeeperController::class,'all'])->name('gate.all');


Route::post('/auth/check',[AuthController::class,'auth'])->name('auth');
Route::post('/auth/register',[AuthController::class,'register'])->name('auth.register');


Route::post('/card/tap',[AuthController::class,'tap'])->name('card.tap');
Route::post('/card/tap/migrate',[InfoMergingController::class,'tap'])->name('card.merge');

Route::get('/card/allTaps', [AuthController::class, 'allTaps'])->name('card.allTaps');
Route::get('/card/allEmployees', [AuthController::class, 'allEmployees'])->name('card.allEmployees');
Route::get('/card/allVisitors', [AuthController::class, 'allVisitors'])->name('card.allVisitors');
// users
Route::post('/user',[UserController::class,'user'])->name('user');

// sychronization


Route::post('/sync/employee',[AuthController::class,'syncEmployee'])->name('sync.syncEmployee');
Route::post('/sync/visitors',[AuthController::class,'syncVisitor'])->name('sync.syncVisitor');



