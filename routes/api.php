<?php

use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ReponsesController;
use App\Http\Controllers\ThemesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);
Route::delete("/logout", [UserController::class, "logout"])->middleware('auth:api');



Route::prefix("/v1/admin")->group(function () {
    Route::get("/getReponseofQuestion", [UserController::class, "getReponseofQuestion"]);


    Route::prefix("/theme")->controller(ThemesController::class)->group(function () {
        Route::get("/index", "index");
        Route::get("/indexThemeId/{id}", "indexThemeId");
        Route::post("/store", "store")->middleware("auth:api");
        Route::get("/edit/{id}", "edit")->middleware("auth:api");
        Route::post("/update/{id}", "update")->middleware("auth:api");
        Route::delete("/destroy/{id}", "destroy")->middleware("auth:api");
    });

    Route::prefix("/question")->controller(QuestionsController::class)->group(function () {
        Route::get("/index", "index");
        Route::post("/store", "store")->middleware("auth:api");
        Route::get("/edit/{id}", "edit")->middleware("auth:api");
        Route::post("/update/{id}", "update")->middleware("auth:api");
        Route::delete("/destroy/{id}", "destroy")->middleware("auth:api");
    });
    Route::prefix("/reponse")->controller(ReponsesController::class)->group(function () {
        Route::get("/index", "index");
        Route::post("/store", "store")->middleware("auth:api");
        Route::get("/edit/{id}", "edit")->middleware("auth:api");
        Route::post("/update/{id}", "update")->middleware("auth:api");
        Route::delete("/destroy/{id}", "destroy")->middleware("auth:api");
    });
});