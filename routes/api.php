<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/users", [UserController::class, "register"]);
Route::post("/users/login", [UserController::class, "login"]);

// menggunakan middleware ApiAuthMiddleware untuk mengecek apakah sudah login atau belum
Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::get("/users/current", [UserController::class, "get"]);
});
