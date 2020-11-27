<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('questions', App\Http\Controllers\QuestionsController::class)->except('show');

// Route::post('/questions/{question}/answers', App\Http\Controllers\AnswersController::class)->name('answers.store');
Route::resource('questions.answers',  App\Http\Controllers\AnswersController::class)->except(['index', 'create', 'show']);
// or ->only(['store', 'edit', 'update', 'destroy']);

Route::get('/questions/{slug}', 'App\Http\Controllers\QuestionsController@show')->name('questions.show');

Route::post('/answers/{answer}/accept', App\Http\Controllers\AcceptAnswerController::class)->name('answers.accept');
