<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Route::post('/token', [ LoginController::class, 'getToken' ]);
Route::get('/questions/{slug}_{qid}', App\Http\Controllers\Api\QuestionDetailsController::class);
Route::get('/questions/{question}/answers', [App\Http\Controllers\Api\AnswersController::class, 'index']);
Route::get('/questions/{slug}', App\Http\Controllers\Api\QuestionDetailsController::class);

Route::middleware(['auth:api'])->group(function() {
	Route::apiResource('/questions', App\Http\Controllers\Api\QuestionsController::class)->except('index');
	Route::apiResource('/questions.answers', App\Http\Controllers\Api\AnswersController::class)->except('index');

	Route::post('/questions/{question}/vote', App\Http\Controllers\Api\VoteQuestionController::class);
	Route::post('/answers/{answer}/vote', App\Http\Controllers\Api\VoteAnswerController::class);

	Route::post('/questions/{question}/favorites', [App\Http\Controllers\Api\FavoritesController::class, 'store']);
	Route::delete('/questions/{question}/favorites', [App\Http\Controllers\Api\FavoritesController::class, 'destroy']);
	
	// One action route => this controller has an __invoke method
	Route::post('/answers/{answer}/accept', App\Http\Controllers\Api\AcceptAnswerController::class);

	Route::get('/my-posts', App\Http\Controllers\Api\MyPostController::class);
});

Route::get('/questions', [ App\Http\Controllers\Api\QuestionsController::class, 'index']);



Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
