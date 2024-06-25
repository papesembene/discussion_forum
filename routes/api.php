<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getAllQuestions',[\App\Http\Controllers\QuestionController::class,'index']);

Route::get('/getAllTags',[\App\Http\Controllers\TagController::class,'index']);

Route::post('/add_question',[\App\Http\Controllers\QuestionController::class,'store']);

Route::get('/question',[\App\Http\Controllers\QuestionController::class,'index']);

