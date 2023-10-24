<?php

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::apiResource('blogs', BlogController::class)->except('index');

    Route::get('getBlogs/{id}', function($id){
        $user = User::find($id);
        return response()->json(['blogs' => $user->blogs ] , 200) ;
    });

    Route::post("/like/{blogId}/{userId}",[LikeController::class,'like']);
    Route::post("/unlike/{blogId}/{userId}",[LikeController::class,'unlike']);

});

Route::get('getBlog/{id}', function($id){
    $blog = Blog::find($id);
    return response()->json(['blog' => $blog] , 200) ;
});

Route::get('blogs', [BlogController::class, 'index']);

Route::post("/register",[UserController::class,'register']);
Route::post("/login",[UserController::class,'login']);
Route::post("/logout",[UserController::class,'logout']);
