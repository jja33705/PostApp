<?php

use App\Http\Controllers\JWTAuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [JWTAuthController::class, 'register'])->name('api.jwt.register');

Route::post('login', [JWTAuthController::class, 'login'])->name('api.jwt.login');

Route::get('unauthorized', function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized',
    ], 401);
})->name('api.jwt.unauthorized');

//미들웨어를 통해 로그린한 사용자와 로그인하지 않은 사용자를  판단. Middleware의 Authenticate.php를 수정하여 로그인하지 않은 사용자는 unauthorized라우트로 리다이렉트시킴
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', [JWTAuthController::class, 'user'])->name('api.jwt.user');
    Route::get('refresh', [JWTAuthController::class, 'refresh'])->name('api.jwt.refresh');
    Route::get('logout', [JWTAuthController::class, 'logout'])->name('jwt.auth.logout');
});