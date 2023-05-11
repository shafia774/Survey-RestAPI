<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SurveyController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);


Route::group(['prefix' => 'survey'], function () {
    Route::post('create', [SurveyController::class, 'create'])->middleware(['auth:api','user-role:Coordinator']);;
    Route::get('list', [SurveyController::class, 'list'])->middleware(['auth:api','user-role:Respondent']);

});

// Route::group(['middleware' => ['auth:api', 'json.response'],['prefix' => 'auth']], function () {

//     //
    
//     });