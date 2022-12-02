<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Collection;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your Api!
|
*/

//Admin only register admin or pengurus
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/register', [\App\http\Controllers\Api\Authcontroller::class, 'register']);
    Route::post('/logout', [\App\http\Controllers\Api\Authcontroller::class, 'logout']);
    Route::put('/user', [\App\http\Controllers\Api\Authcontroller::class, 'update']);
    Route::Delete('/user/{id}', [\App\http\Controllers\Api\Articlecontroller::class, 'destroy']);

});

//login
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

//get all user
Route::get('/user', [\App\http\Controllers\Api\Authcontroller::class, 'getAllUser']); 

/*********************************   Enpoint Articles Route Starts Here   ****************************/
//Create Article
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/article', [\App\http\Controllers\Api\Articlecontroller::class, 'createArticle']);
    Route::put('/article/{id}', [\App\http\Controllers\Api\Articlecontroller::class, 'updateArticle']);
    Route::Delete('/article/{id}', [\App\http\Controllers\Api\Articlecontroller::class, 'deleteAticle']);
    Route::Delete('/article', [\App\http\Controllers\Api\Articlecontroller::class, 'deleteArticle']);
});

//get all article
Route::get('/article', [\App\http\Controllers\Api\Articlecontroller::class, 'getAllArticle']);

//get article by id
Route::get('/article/{id}', [\App\http\Controllers\Api\Articlecontroller::class, 'getArticleById']);




