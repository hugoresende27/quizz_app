<?php

use App\Http\Controllers\QuizzController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/questions', [QuizzController::class, 'index']);
Route::get('/questions/all', [QuizzController::class, 'getAllQuestions']);
Route::get('/questions/category/{category}', [QuizzController::class, 'getQuestionsByCategory']);
Route::get('/questions/tag/{tag}', [QuizzController::class, 'getQuestionsByTag']);
Route::get('/questions/filter', [QuizzController::class, 'getFilteredQuestions']);

