<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\AuthController;
use App\Modules\Blogs\Controllers\BlogController;
use App\Modules\Likes\Controllers\LikeController;
use App\Modules\Posts\Controllers\PostController;
use App\Modules\Comments\Controllers\CommentController;

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

Route::middleware([ 'token.guard' ])->group(function(){

    // blogs
    Route::post('create/blog', [BlogController::class, 'store']);
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blog/{blog}', [BlogController::class, 'show']);
    Route::put('edit/blog/{blog}', [BlogController::class, 'update']);
    Route::delete('delete/blog/{blog}', [BlogController::class, 'destroy']);

    //posts
    Route::post('create/post', [PostController::class, 'store']);
    Route::get('posts', [PostController::class, 'index']);
    Route::get('post/{post}', [PostController::class, 'show']);
    Route::put('edit/post/{post}', [PostController::class, 'update']);
    Route::delete('delete/post/{post}', [PostController::class, 'destroy']);

    //comment
    Route::post('store/comment/{post}', [CommentController::class, 'store']);

    //like
    Route::post('store/like/{post}', [LikeController::class, 'store']);


});
