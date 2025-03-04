<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::middleware("guest")->group(function () {
        Route::post("/users", "store");
    });

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/user", "user");
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post("/auth/login", "login")->middleware("guest");
    Route::post("/auth/logout", "logout")->middleware("auth:sanctum");
});
