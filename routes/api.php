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



Route::prefix("/v1/admin")->group(function () {
    Route::get("/getReponseofQuestion", [UserController::class, "getReponseofQuestion"]);


    Route::prefix("/theme")->controller(ThemesController::class)->group(function () {
        Route::get("/index", "index");
        Route::get("/indexThemeId/{id}", "indexThemeId");
        Route::post("/store", "store");
        Route::get("/edit/{id}", "edit");
        Route::post("/update/{id}", "update");
        Route::delete("/destroy/{id}", "destroy");
    });

    Route::prefix("/question")->controller(QuestionsController::class)->group(function () {
        Route::get("/index", "index");
        Route::post("/store", "store");
        Route::get("/edit/{id}", "edit");
        Route::post("/update/{id}", "update");
        Route::delete("/destroy/{id}", "destroy");
    });
    Route::prefix("/reponse")->controller(ReponsesController::class)->group(function () {
        Route::get("/index", "index");
        Route::post("/store", "store");
        Route::get("/edit/{id}", "edit");
        Route::post("/update/{id}", "update");
        Route::delete("/destroy/{id}", "destroy");
    });
});