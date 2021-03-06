<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

Route::prefix('v1.0.0')->name('api.')->namespace('Api\V1_0_0')->group(function () {
    Route::get('/status', function () {
        return response()->json(['status' => 'OK']);
    })->name('status');

    Route::apiResource('posts.comments', 'PostCommentController');
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page has not been found!'
    ], 404);
})->name('api.fallback');
