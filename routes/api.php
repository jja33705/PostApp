<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PostController;
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

Route::post('register', [JWTAuthController::class, 'register'])->name('api.jwt.register');

Route::post('login', [JWTAuthController::class, 'login'])->name('api.jwt.login');

Route::get('unauthorized', function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized',
    ], 401);
})->name('api.jwt.unauthorized');

Route::get('/index', [PostController::class, 'index'])->name('api.post.index');


Route::get('post/show/{id}', [PostController::class, 'show'])->name('api/post/show');

//미들웨어를 통해 로그인한 사용자와 로그인하지 않은 사용자를  판단. Middleware의 Authenticate.php를 수정하여 로그인하지 않은 사용자는 unauthorized라우트로 리다이렉트시킴
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', [JWTAuthController::class, 'user'])->name('api.jwt.user');
    Route::get('refresh', [JWTAuthController::class, 'refresh'])->name('api.jwt.refresh');
    Route::get('logout', [JWTAuthController::class, 'logout'])->name('jwt.auth.logout');
    Route::post('post/store', [PostController::class, 'store'])->name('api.post.store');
    Route::post('post/like/{id}', [PostController::class, 'like'])->name('api/post/like');
    Route::post('comment/{id}', [CommentController::class, 'store'])->name('api/comment/store');
    Route::delete('comment/{id}', [CommentController::class, 'delete'])->name('api/comment/delete');
    Route::delete('post/{id}', [PostController::class, 'delete'])->name('api/post/delete');
    Route::patch('post/{id}', [PostController::class, 'edit'])->name('api/post/edit');
});
