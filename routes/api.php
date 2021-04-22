<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ProducerController;
use App\Http\Controllers\Api\ActorController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FilmActorController;
use App\Http\Controllers\Api\FilmProducerController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout']);


Route::group([
    'middleware' => 'jwtAuth',
], function ($router) {
    Route::post('save_user_info', [AuthController::class, 'saveUserInfo']);

    Route::resource('genres', GenreController::class)->except([ 'create' ]);
    Route::resource('certificates', CertificateController::class)->except([ 'create' ]);
    Route::resource('roles', RoleController::class)->except([ 'create' ]);
    Route::resource('producers', ProducerController::class)->except([ 'create' ]);
    Route::resource('actors', ActorController::class)->except([ 'create' ]);
    Route::resource('movies', MovieController::class);
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('filmactors', FilmActorController::class);
    Route::resource('filmproducers', FilmProducerController::class);

});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
