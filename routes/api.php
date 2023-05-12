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
    Route::post('edit', [SurveyController::class, 'edit'])->middleware(['auth:api','user-role:Coordinator']);;
    Route::post('delete', [SurveyController::class, 'delete'])->middleware(['auth:api','user-role:Coordinator']);;
    Route::post('editquestion', [SurveyController::class, 'editQuestion'])->middleware(['auth:api','user-role:Coordinator']);;
    Route::post('deletequestion', [SurveyController::class, 'deleteQuestion'])->middleware(['auth:api','user-role:Coordinator']);;
    Route::get('list', [SurveyController::class, 'list'])->middleware(['auth:api','user-role:Respondent']);
    Route::get('view', [SurveyController::class, 'view'])->middleware(['auth:api','user-role:Respondent']);
    Route::post('report', [SurveyController::class, 'report'])->middleware(['auth:api','user-role:Respondent']);

});

// Route::group(['middleware' => ['auth:api', 'json.response'],['prefix' => 'auth']], function () {

//     //
    
//     });