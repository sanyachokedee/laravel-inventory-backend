<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;   //เรียกมา
use App\Http\Controllers\AuthController;

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

//Public routes ไว้ตรงนี้เพื่อให้คนนอกมาใบ้ได้
Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);


//Protected routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('products', ProductController::class);  //แสดงข้อมูล table:products
    Route::post('logout',[AuthController::class, 'logout']);
});

// Route::resource('products', ProductController::class);  //พิมพ์ใหม่

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
