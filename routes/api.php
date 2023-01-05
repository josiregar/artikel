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
    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::put('/user', [App\Http\Controllers\Api\Authcontroller::class, 'update']);
    Route::Delete('/user/{id}', [App\Http\Controllers\Api\AuthController::class, 'destroy']);

});

//login
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

//get all user
Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getAllUser']);

/**********************************   Enpoint Articles Route Starts Here   *******************************************/
/**Create Article*/
Route::middleware('auth:sanctum')->group(function() {
/**Create Article*/
Route::post('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'createArticle']);
/**Update Articles*/
Route::put('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'updateArticle']);
/**Delete Article By Id*/
Route::delete('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'deleteArticle']);
/**Delete all Article*/
Route::delete('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'deleteAllArticle']);
});
/**Get All Article*/
Route::get('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'getAllArticle']);
/**Get Article By Id*/
Route::get('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'getArticleById']);
/**********************************   Enpoint Articles Route Ends Here   *******************************************/


//get all article
Route::get('/article', [\App\Http\Controllers\Api\Articlecontroller::class, 'getAllArticle']);

//get article by id
Route::get('/article/{id}', [\App\Http\Controllers\Api\Articlecontroller::class, 'getArticleById']);


//create mahasiswa
Route::post('/mahasiswa', [\App\Http\Controllers\Api\MahasiswaController::class, 'createMahasiswa']);

//get all mahasiswa
Route::get('/mahasiswa', [\App\Http\Controllers\Api\MahasiswaController::class, 'getAllMahasiswa']);

//get mahasiswa by id
Route::get('/mahasiswa/{id}', [\App\Http\Controllers\Api\MahasiswaController::class, 'getMahasiswaById']);

//update mahasiswa 
Route::put('/mahasiswa/{id}', [\App\Http\Controllers\Api\MahasiswaController::class, 'updateMahasiswa']);

//delete mahasiswa by id 
Route::delete('/mahasiswa/{id}', [\App\Http\Controllers\Api\MahasiswaController::class, 'deleteMahasiswa']);