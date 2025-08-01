<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;

Route::prefix('v1')->group(function () {
    Route::get('/news', [NewsController::class, 'index']);
    
    Route::get('/news/{id}', [NewsController::class, 'show']);
    
    Route::get('/news/stats/overview', [NewsController::class, 'stats']);
    
    Route::get('/news/author/{author}', [NewsController::class, 'byAuthor']);
}); 